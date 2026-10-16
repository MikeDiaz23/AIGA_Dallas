# AIGA Dallas WordPress themes

Source repository for the supplied AIGA iKit Three themes. Both uploads were
imported without changing their contents, including hidden `.style_editor`
files. Archive hashes and file counts are recorded in
[docs/theme-imports.json](docs/theme-imports.json). Current setup results and
remaining limitations are in [docs/validation.md](docs/validation.md).
The later backup comparison and saved dependency metadata are documented in
[docs/backup-reference.md](docs/backup-reference.md).

| Directory | Role |
| --- | --- |
| `themes/ikit_three/` | Original iKit Three 3.0.0 parent theme |
| `themes/ikit_three_custom/` | Original iKit Three Custom 1.0.0 child theme; use this for Dallas changes |
| `scripts/` | Local development, validation, and release packaging |
| `.local/plugins/` | Ignored local plugins, including the separately supplied iKit plugin |
| `dist/` | Generated uploadable theme ZIPs, ignored by Git |

## Start development

For a VS Code/browser workflow on your own computer, follow
[docs/vscode-local.md](docs/vscode-local.md). VS Code tasks are in
`.vscode/tasks.json`; open `AIGA_Dallas.code-workspace` to use this project.

Requirements: Docker Engine with Compose v2, Python 3, GNU Make, Bash, and curl.
PHP, WordPress, WP-CLI, MariaDB, and an Nginx gateway run in containers; no global PHP/Node packages
are required. Images are pinned in `compose.yaml`. This is a local development
configuration, not a production deployment.

```sh
make setup     # generate local credentials, pull images, start and install WordPress
make import-plugins # verify/import the four supplied ZIPs from your Downloads folder
make prepare-theme # activate supplied ACF plugins, iKit, and child theme in order
make smoke     # check rendered HTML, login form, and REST content types
make theme-smoke # verify active child, published page/post templates, and theme assets
make check     # check theme layout and lint every PHP file
make package   # build dist/ikit_three.zip and dist/ikit_three_custom.zip
make down      # stop containers; retain database and WordPress volumes
make up        # restart, preserving an existing WordPress installation
```

The web server binds only to the machine's loopback interface on port 8080.
WordPress, WP-CLI, and MariaDB use an internal Docker network with no Internet
route. The gateway exposes the site locally without giving WordPress outbound
access. Cron and external WordPress HTTP requests are also disabled. Container
image downloads still run through the host's Docker engine.
`make setup` creates an ignored, mode-600 `.env` with random database and
development-admin passwords. Read that file locally when credentials are needed;
never commit it. `.env.example` documents the available settings. Change
`WORDPRESS_PORT` in `.env` if the port is occupied. Existing `.env` files are never
overwritten. Keep `.env` alongside existing volumes: changing its passwords does
not change credentials in an already initialized database or admin account.

A newly installed WordPress site starts with a bundled default theme. The
prepared cloud instance now has the iKit child theme active, together with its
four supplied plugin dependencies. `make prepare-theme` reproduces their
activation when those files are present under `.local/plugins/`. A fresh Git
clone needs the separately supplied plugin ZIPs; plugin source is not in Git.
The local site uses WordPress sample content. Creating its volumes does not
import Dallas content, media, menus, Elementor layouts, or member data.

## Required for the existing iKit themes

The parent theme unconditionally extends `Ikit_Widget` and calls plugin
functions including `ikit_ssl_redirect()` and `ikit_style_editor_enqueue_style()`.
The supplied plugins are installed unchanged under ignored `.local/plugins/`:

| Plugin | Version | PHP files checked |
| --- | --- | --- |
| iKit | 1.0.0 | 90 |
| Advanced Custom Fields | 4.4.7 | 42 |
| ACF Repeater Field | 1.1.1 | 5 |
| ACF WP WYSIWYG | 1.0.2 | 4 |

All four activate successfully on the pinned development runtime, and their 141
PHP files pass syntax checks. Plugin archive hashes and counts are recorded in
[docs/plugin-imports.json](docs/plugin-imports.json). Plugin source and embedded
API configuration remain outside Git. macOS metadata was excluded when extracting
the ZIPs; application code was not patched.

1. Keep the supplied `advanced-custom-fields/`, `acf-repeater/`,
   `acf-wordpress-wysiwyg-field-master/`, and `ikit/` directories in
   `.local/plugins/`, with readable directories/files (normally 755/644).
   Do not replace legacy ACF with a newer major version without checking
   compatibility.
2. Run `make prepare-theme`. It activates ACF before its extensions and iKit,
   activates `ikit_three_custom`, and runs functional checks. Repeated runs
   preserve the installed site and handle already-active plugins.
3. For manual activation, activate ACF before iKit:
   `./scripts/dev.sh wp --skip-themes --skip-plugins=ikit plugin activate advanced-custom-fields`.
   Activate the supplied ACF extensions next, then run
   `./scripts/dev.sh wp --skip-themes plugin activate ikit`.
   Then run `make activate` to verify ACF and key iKit APIs before switching the
   child theme and checking its pages and assets.

Legacy plugins emit PHP 8.3 deprecation warnings during CLI bootstrap, including
dynamic properties in ACF and parameter ordering in iKit. They do not block the
validated page or asset requests. Their source remains unchanged; full PHP
modernization is a separate code task. No assertions or TLS checks were disabled.

The source also contains legacy Advanced Custom Fields integration
(`register_field_group`) and an export under
`themes/ikit_three/tools/installation/`. Confirm the current site's ACF version
and other plugin dependencies before importing configuration or upgrading.
The supplied code does not establish which WordPress/PHP versions the live site
supports. The backup confirms ACF 4.4.7 and active iKit/Elementor integrations;
see the backup reference before choosing plugin versions. Syntax checks alone
do not establish runtime compatibility.

WP-CLI examples:

```sh
./scripts/dev.sh wp --skip-themes theme list --skip-update-check
./scripts/dev.sh wp --skip-themes plugin list --skip-update-check
./scripts/dev.sh wp --skip-themes option get stylesheet
```

If a manually activated theme breaks the site, recover without loading themes:
use `./scripts/dev.sh wp --skip-themes theme list --skip-update-check`, then
`./scripts/dev.sh wp --skip-themes theme activate <bundled-default-theme>`.

## Update or create themes

Make Dallas-specific styles and template overrides in `ikit_three_custom`.
Keep its `Template: ikit_three` header and install the parent alongside it.
The parent already links both the parent and child `style.css` files, so the
child's `style.css` can hold overrides without an extra enqueue function.
Parent source is mounted read-only in WordPress to prevent dashboard changes;
edit it in the repository only for intentional shared parent fixes.

The `.style_editor` files belong to the legacy iKit style editor. Both Sass source
and compiled CSS are retained. iKit invokes `sassc` for style-editor compilation;
that dashboard compilation workflow and its write permissions are not configured
or validated here. There is no supplied standalone Sass build configuration.
Ordinary CSS overrides in the child stylesheet need no build step.

A new independent theme can be created under `themes/<new-slug>/`. It needs its
own WordPress headers/templates and a Compose bind mount. Add it to the packaging
script's theme list and validation rules if it should ship from this repository.
Do not give an independent theme `Template: ikit_three` unless it is a child.

## Package and publish

`make package` creates one WordPress-ready ZIP per theme, each with its correctly
named enclosing directory and all hidden style-editor assets. Install the parent
before the child. CI runs the same structure/PHP checks and uploads the ZIPs as
build artifacts; runtime iKit checks require the separately provided plugins.
Third-party AIGA theme notices and assets retain their original ownership; no
new license is asserted for the imported code.

The GitHub project contains the themes, setup scripts, and VS Code workspace.
Use **Code → Download ZIP** for the project, then import the four original plugin
ZIPs using the local guide. Plugin source, databases, and local passwords stay
outside Git. Installing a generated theme ZIP on a live site is a separate step;
validate changes on staging with matching plugins and sanitized content first.
