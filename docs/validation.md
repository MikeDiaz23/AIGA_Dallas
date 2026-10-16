# Setup validation

Validated in the cloud workspace on October 15, 2026.

Runtime: WordPress 7.1.3, PHP 8.3.35, MariaDB 11.4.13, Docker Compose v2.40.3,
and a pinned Nginx gateway. Image digests are in `compose.yaml`. These are the
development versions tested here; the production PHP version remains unknown.

| Check | Result |
| --- | --- |
| Original theme imports and later backup | All 148 repository theme files match both supplied theme sources |
| `make check` | Both theme structures valid; all 39 theme PHP files pass PHP 8.3 lint |
| Supplied plugin imports | All 307 plugin files match uploads after excluding macOS metadata; source stays outside Git |
| Plugin syntax checks | All 141 PHP files pass: iKit 90, ACF 42, Repeater 5, WP WYSIWYG 4 |
| Plugin activation | ACF 4.4.7, Repeater 1.1.1, WP WYSIWYG 1.0.2, and iKit 1.0.0 all activate |
| `make prepare-theme` | Repeated activation in dependency order succeeds without resetting the site |
| Child theme | `ikit_three_custom` is active with parent `ikit_three`; required iKit classes and event post type are available |
| `make smoke` | Homepage, login form, and REST post/page types pass with the child theme active |
| `make theme-smoke` | Child-theme homepage and published page/post templates render; six required CSS/JS assets are included and match repository bytes |
| Browser validation | Desktop homepage and sample page finish loading; jQuery and theme JS initialize; no uncaught JavaScript exceptions |
| `make package` | Both installable ZIPs generated with hidden assets; prior repeated packaging produced identical hashes |
| Service lifecycle | Setup and stop/start preserve the site; gateway and internal application network validated |
| Container isolation | WordPress has only an internal network; direct Internet connection blocked; cron and WordPress external HTTP disabled |
| Local configuration | `.env` is mode 600; credentials, plugins, private references, SQL dumps, and generated ZIPs are excluded from Git |
| GitHub Actions | Workflow added; not executed on GitHub |
| Live site / new cloud task | Not deployed or independently validated |

The browser check blocked external requests and used local sample content. It
does not validate production font services, Elementor-managed layouts, mobile
behavior, navigation settings, member/event integrations, commerce, or editing
and style-editor workflows. No production database or uploads were restored.

Legacy ACF produces PHP 8.3 dynamic-property deprecation warnings during CLI
bootstrap; iKit also reports a deprecated parameter declaration. These are
upstream code compatibility issues. They did not prevent activation or the
validated HTTP/browser requests, and no application/plugin source was patched
or assertions disabled to make checks pass. Source modernization is separate
from environment setup.

The initial iKit activation error (`acf_field` absent) was resolved by the
supplied ACF plugins. An earlier disk-space failure was resolved by removing an
unused image downloaded during setup; installation and restart then passed.

Plugin provenance is in [plugin-imports.json](plugin-imports.json). Backup
metadata and the scope of the local copy are in
[backup-reference.md](backup-reference.md). Continue with sanitized staging data
and the remaining plugins when testing full live-site behavior.
