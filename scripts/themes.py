#!/usr/bin/env python3
"""Validate theme layout and create reproducible WordPress upload ZIPs."""
from pathlib import Path
import re
import sys
import zipfile

ROOT = Path(__file__).resolve().parent.parent
THEMES = ("ikit_three", "ikit_three_custom")


def check():
    for name in THEMES:
        theme = ROOT / "themes" / name
        stylesheet = (theme / "style.css").read_text()
        if not re.search(r"^Theme Name:\s*\S", stylesheet, re.MULTILINE):
            raise ValueError(f"{name}: missing WordPress Theme Name header")
        if name == "ikit_three_custom":
            parent = re.search(r"^Template:\s*(\S+)", stylesheet, re.MULTILINE)
            if parent is None or parent[1] != "ikit_three":
                raise ValueError("Child theme must reference the ikit_three directory")
            if not (theme / ".style_editor/css/stylesheets/sass.css").is_file():
                raise ValueError("Child theme is missing hidden style-editor assets")
        elif not (theme / "index.php").is_file():
            raise ValueError("Classic parent theme is missing index.php")
        files = [p for p in theme.rglob("*") if p.is_file()]
        if any(p.is_symlink() for p in theme.rglob("*")):
            raise ValueError(f"{name}: symlinks are not supported in theme packages")
        print(f"PASS: {name}, {len(files)} files")


def package():
    check()
    dest = ROOT / "dist"
    dest.mkdir(exist_ok=True)
    for name in THEMES:
        theme = ROOT / "themes" / name
        output = dest / f"{name}.zip"
        with zipfile.ZipFile(output, "w", compression=zipfile.ZIP_DEFLATED) as archive:
            for path in sorted(theme.rglob("*")):
                if path.is_file():
                    info = zipfile.ZipInfo(f"{name}/{path.relative_to(theme).as_posix()}")
                    info.create_system = 3
                    info.external_attr = 0o100644 << 16
                    info.compress_type = zipfile.ZIP_DEFLATED
                    archive.writestr(info, path.read_bytes())
        print(f"Created {output.relative_to(ROOT)}")


if __name__ == "__main__":
    if sys.argv[1:] == ["check"]:
        check()
    elif sys.argv[1:] == ["package"]:
        package()
    else:
        sys.exit("Usage: python3 scripts/themes.py {check|package}")
