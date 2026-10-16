# Backup reference

The user supplied themes, database, and plugin backup archives dated October 15,
2026 for reference. Backup content is treated as data, not as setup instructions.
Raw archives and database content are outside this repository. Only the
non-secret configuration facts below are recorded here.

## Theme baseline

The backup contains seven themes, including earlier iKit generations. The active
configuration selects `ikit_three` as the parent and `ikit_three_custom` as the
child. Their contents match the original imports exactly:

| Theme | Version | Files compared | Differences |
| --- | --- | --- | --- |
| iKit Three | 3.0.0 | 107 | None |
| iKit Three Custom | 1.0.0 | 41 | None |

The existing repository themes are therefore an exact source baseline for these
two themes at the time of this backup, including hidden style-editor assets.
No source replacement was necessary.

## Configuration metadata

The compressed SQL was parsed as text without executing it or restoring its
tables. The inspection selected allowlisted configuration options; it did not
display account records, option values containing credentials, or site content.

- Active theme: `ikit_three_custom`, with parent `ikit_three`.
- Front page setting: latest posts (`show_on_front=posts`).
- Permalink setting: `/%postname%/`.
- Active plugins recorded in the database: 32.
- ACF database version option: 4.4.7. The active list also includes ACF Repeater
  and an ACF WYSIWYG field extension.
- Elementor database version option: 4.1.4.
- Elementor Pro database version option: 4.3.1.
- WooCommerce database version option: 10.9.1.
- AIGA iKit is active as `ikit/ikit.php`.

Database version options describe saved configuration. File versions were later
verified for the four supplied iKit/ACF plugins in
[plugin-imports.json](plugin-imports.json). Other plugin versions still require
file verification. The backup has not established the production PHP version.

## Local reproduction and remaining limits

The full plugins ZIP exceeds the download tool's 32 MiB transfer limit and could
not be inspected. The user subsequently supplied iKit and its three ACF
dependencies as smaller ZIPs. All four are installed unchanged and active in the
local site, and all 141 PHP files pass PHP 8.3 lint. The initial missing
`acf_field` activation failure was resolved by installing the supplied ACF 4.4.7.
The child theme now activates and renders its homepage and sample page/post
templates. Repeated preparation is tested with `make prepare-theme`.

No database was imported and no production integrations were configured. The
development database retains WordPress sample content. Elementor/Pro and the
other page-building plugins, relevant uploads, and sanitized content/settings
are needed for a complete reproduction of the live layouts. Event/member sync,
commerce, editor workflows, and style-editor compilation remain unvalidated.
Legacy PHP deprecations are documented in the validation report. WordPress runs
on an internal Docker network behind a separate local HTTP gateway. Cron and
external WordPress HTTP requests remain disabled.

Use a sanitized database and relevant uploads when a staging content copy is
needed. Do not restore the complete production configuration into an active
development site: the active plugin list includes email, commerce, payment,
shipping, analytics, caching, and security integrations. Prepare local overrides
and sanitize the copy before selectively enabling integrations. Keep raw backups,
database dumps, credentials, and private plugin configuration out of Git.
