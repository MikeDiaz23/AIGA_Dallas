#!/usr/bin/env python3
"""Import the user's original plugin ZIPs without adding plugin code to Git."""
import argparse
import hashlib
import json
from pathlib import Path, PurePosixPath
import stat
import tempfile
import zipfile

ROOT = Path(__file__).resolve().parent.parent


def digest(path):
    result = hashlib.sha256()
    with path.open("rb") as source:
        for chunk in iter(lambda: source.read(1024 * 1024), b""):
            result.update(chunk)
    return result.hexdigest()


def metadata(parts):
    return any(p in ("__MACOSX", ".DS_Store") or p.startswith("._") for p in parts)


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("folder", nargs="?", type=Path, default=Path.home() / "Downloads",
                        help="Folder containing the four original plugin ZIPs (default: Downloads)")
    args = parser.parse_args()
    records = json.loads((ROOT / "docs/plugin-imports.json").read_text())["imports"]
    plans = []
    for record in records:
        candidates = sorted(args.folder.expanduser().glob(Path(record["archive"]).stem + "*.zip"))
        archive = next((p for p in candidates if p.is_file() and digest(p) == record["archive_sha256"]), None)
        if archive is None:
            raise ValueError(f"Missing original ZIP or checksum mismatch: {record['archive']}. Put the unchanged ZIP in the selected folder.")
        files = {}
        with zipfile.ZipFile(archive) as source:
            if sum(i.file_size for i in source.infolist()) > 64 * 1024 * 1024:
                raise ValueError("Plugin archive exceeds the import size limit")
            for entry in source.infolist():
                path = PurePosixPath(entry.filename)
                if path.is_absolute() or ".." in path.parts or "\\" in entry.filename or stat.S_ISLNK(entry.external_attr >> 16):
                    raise ValueError("Unsafe archive path")
                if entry.is_dir() or metadata(path.parts):
                    continue
                if not path.parts or path.parts[0] != record["plugin"] or len(path.parts) < 2:
                    raise ValueError(f"Unexpected plugin layout: {record['archive']}")
                relative = Path(*path.parts[1:])
                if relative in files:
                    raise ValueError("Duplicate archive file")
                files[relative] = source.read(entry)
        if len(files) != record["files"]:
            raise ValueError(f"Unexpected file count: {record['archive']}")
        destination = ROOT / record["storage"]
        if not destination.resolve().is_relative_to(ROOT):
            raise ValueError("Plugin destination escapes the project")
        if destination.exists():
            if destination.is_symlink() or any(p.is_symlink() for p in destination.rglob("*")):
                raise ValueError("Existing plugin contains a symlink; no files changed")
            existing = {p.relative_to(destination): p.read_bytes() for p in destination.rglob("*")
                        if p.is_file() and not metadata(p.relative_to(destination).parts)}
            if existing != files:
                raise ValueError(f"Preserving existing changes in {record['storage']}; import stopped.")
        plans.append((record, files, destination))

    plugins = ROOT / ".local/plugins"
    plugins.mkdir(parents=True, exist_ok=True)
    with tempfile.TemporaryDirectory(prefix=".plugin-import-", dir=plugins) as temporary:
        stage = Path(temporary)
        for record, files, destination in plans:
            if destination.exists():
                continue
            staged = stage / record["plugin"]
            for relative, content in files.items():
                path = staged / relative
                path.parent.mkdir(parents=True, exist_ok=True)
                path.write_bytes(content)
                path.chmod(0o644)
            for path in [staged, *staged.rglob("*")]:
                if path.is_dir():
                    path.chmod(0o755)
        for record, _, destination in plans:
            if not destination.exists():
                (stage / record["plugin"]).rename(destination)
            print(f"Ready: {record['plugin']} {record['version']} (original ZIP verified)")


if __name__ == "__main__":
    try:
        main()
    except (OSError, ValueError, zipfile.BadZipFile) as error:
        raise SystemExit(f"Plugin import stopped: {error}")
