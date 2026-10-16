# Run the themes on your computer with VS Code

VS Code edits the source files. Docker runs WordPress, PHP, and MariaDB. Your
browser displays the site running on your own computer. Saving a PHP/CSS change
in the mounted theme directory makes it available on the next browser refresh;
there is no build step for ordinary child-theme CSS.

## Install the tools

- Mac quick start: VS Code is your editor; Docker Desktop must also be
  installed and running. Open a VS Code terminal and check
  `docker compose version`, `python3 --version`, and `make --version`.
  Python 3.9 or newer is sufficient. If Make/Git are missing, run
  `xcode-select --install` in the Mac terminal to install Apple's command-line
  tools. Install Python 3 from its official installer if it is not available.
- Install VS Code and Docker Desktop, then start Docker Desktop.
- The terminal also needs Bash, Python 3, GNU Make, and curl. Git is useful for
  version control but is not required to open a project ZIP in VS Code.
- On Windows, use WSL 2 with Ubuntu, enable Docker Desktop's integration for
  that distribution, and open the project through VS Code's WSL extension. In
  the Ubuntu terminal, install prerequisites with
  `sudo apt-get update` and `sudo apt-get install -y make python3 curl git`.
  Keep the project in the WSL home directory and open it with `code .`.
- On macOS, install the Xcode command-line tools for Make and Git; ensure
  `python3`, `bash`, and `curl` are available in the VS Code terminal.
- On Linux, Docker Engine with the Compose v2 plugin can replace Docker Desktop.
  Install the same shell prerequisites through your distribution.

The pinned container manifests include Intel/AMD64 and Apple Silicon/ARM64 builds.
The stack and commands were validated on the cloud's Linux machine; they have
not been run on your physical Mac or tested in a VS Code window here.

## Open the prepared project

Open your `MikeDiaz23/AIGA_Dallas` GitHub repository and choose **Code → Download
ZIP**, or clone it. Extract the download, then in VS Code choose **File → Open
Workspace from File** and select `AIGA_Dallas.code-workspace` inside the extracted
project folder. You can also open that folder directly.

The GitHub download contains both themes and the project configuration. The
plugin source, passwords, database dumps, site content, and generated logs are
excluded. Your Mac will generate its own local credentials.

Put these four original plugin ZIPs in your Mac's **Downloads** folder:

- `advanced-custom-fields.zip`
- `acf-repeater.zip`
- `acf-wordpress-wysiwyg-field-master.zip`
- `ikit.zip`

`make import-plugins` verifies their recorded SHA-256 checksums and imports them
into the ignored directory below. It ignores macOS metadata, preserves existing
plugin modifications, and stops before installing if a required ZIP is missing
or does not match. For a different ZIP folder, run
`python3 scripts/import-plugins.py /path/to/your/folder` instead.

```text
AIGA_Dallas/
  compose.yaml
  .local/
    plugins/
      advanced-custom-fields/acf.php
      acf-repeater/acf-repeater.php
      acf-wordpress-wysiwyg-field-master/acf-wp_wysiwyg.php
      ikit/ikit.php
  themes/
    ikit_three/
    ikit_three_custom/
```

Avoid an extra nested folder such as `plugins/ikit/ikit/ikit.php`. macOS ZIPs
may also contain a `__MACOSX` directory; do not put that in the plugins folder.
Plugin versions and original archive hashes are in `plugin-imports.json`.

## First run

In VS Code's integrated terminal, from the project root:

```sh
make setup
make import-plugins
make prepare-theme
```

Alternatively, choose **Terminal → Run Task → WordPress: First run**. This first
imports the original ZIPs from Downloads, then starts WordPress and activates the
theme. The tasks
use the same tested Make commands and require those prerequisites in VS Code's
environment. On Windows, run them in the WSL project window.

Open your own browser to **localhost on port 8080**. This is a local address on
your computer; it is not a link to the cloud onboarding environment. For the
WordPress dashboard, use the same local address with `/wp-admin` appended. The
local username is `developer`; the generated password is in your project's
ignored `.env` file as `WP_ADMIN_PASSWORD`. It is unrelated to the live site
login. Do not upload or commit `.env`.

## Edit and preview

1. Edit `themes/ikit_three_custom/style.css` for Dallas CSS overrides, or add
   child-theme template overrides.
2. Save in VS Code and refresh the local browser. If CSS appears cached, use
   a hard refresh. The default stack does not provide automatic browser reload.
3. Run `make theme-smoke` for the active theme and served assets, and
   `make check` for theme structure and PHP syntax.
4. Run `make package` when you want installable theme ZIPs in `dist/`.

Later sessions use `make up` to start and `make down` to stop. Corresponding
VS Code tasks are supplied. Stopping keeps the database. Keep `.env` with those
volumes; changing passwords in `.env` does not update an existing database.
Change `WORDPRESS_PORT` before the first setup if port 8080 is occupied.

The local site starts with sample content and the supplied themes/plugins. It
does not reproduce Dallas content, media, menus, or Elementor layouts. The full
production database was not restored. Native iKit synchronization requests,
WordPress outgoing HTTP, and cron remain blocked; external font/integration
behavior is outside the current checks. Legacy PHP deprecation warnings are
documented in `validation.md`. Do not use this stack as a production deployment.
