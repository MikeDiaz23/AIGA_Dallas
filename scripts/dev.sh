#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")/.."

compose() { docker compose "$@"; }
wp() { compose run --rm -T cli wp "$@"; }

init_local() {
  # Cloud checkouts can use a restrictive umask; containers must read theme code.
  find themes -type d -exec chmod a+rx {} +
  find themes -type f -exec chmod a+r {} +
  chmod a+r docker/nginx.conf
  mkdir -p .local/plugins
  if [ -O .local/plugins ]; then chmod 755 .local/plugins; fi
  python3 - <<'PY'
from pathlib import Path
import os, secrets
path = Path('.env')
if not path.exists():
    values = {
        'WORDPRESS_PORT': '8080',
        'DB_PASSWORD': secrets.token_hex(24),
        'DB_ROOT_PASSWORD': secrets.token_hex(24),
        'WP_ADMIN_USER': 'developer',
        'WP_ADMIN_PASSWORD': secrets.token_hex(24),
        'WP_ADMIN_EMAIL': 'developer@example.test',
    }
    with os.fdopen(os.open(path, os.O_WRONLY | os.O_CREAT | os.O_EXCL, 0o600), 'w') as f:
        f.writelines(f'{key}={value}\n' for key, value in values.items())
    print('Created ignored .env with random local credentials; existing files are preserved.')
PY
}

start() {
  init_local
  compose up -d --wait --wait-timeout 180 db wordpress gateway
  # Linux bind mounts need the developer group restored after first boot.
  # Docker Desktop on macOS manages shared-folder ownership on the host.
  if [ "$(uname -s)" = Linux ]; then
    compose exec -T --user root wordpress chgrp "$(id -g)" /var/www/html/wp-content/plugins
    compose exec -T --user root wordpress chmod 2775 /var/www/html/wp-content/plugins
  fi
  if ! wp core is-installed --skip-plugins --skip-themes; then
    compose run --rm -T --entrypoint sh cli -c '
      exec wp core install --skip-plugins --skip-themes \
        --url="http://localhost:$WORDPRESS_PORT" --title="AIGA Dallas Development" \
        --admin_user="$WP_ADMIN_USER" --admin_password="$WP_ADMIN_PASSWORD" \
        --admin_email="$WP_ADMIN_EMAIL" --skip-email
    '
  fi
  wp theme list --skip-themes --skip-update-check --fields=name,status,version
  echo 'WordPress started; active and installed themes are listed above.'
}

case "${1:-}" in
  setup)
    init_local
    compose --profile tools pull
    start
    ;;
  start) start ;;
  stop) compose down ;;
  wp) shift; wp "$@" ;;
  lint)
    # Uses the pinned PHP runtime without starting WordPress or a database.
    image=$(python3 - <<'PY'
import re
from pathlib import Path
print(re.search(r'  wordpress:\n    image: (\S+)', Path('compose.yaml').read_text())[1])
PY
)
    docker run --rm --network none --entrypoint sh \
      --mount "type=bind,src=$PWD/themes,dst=/themes,readonly" "$image" -c '
        find /themes -type f -name "*.php" -print0 | xargs -0 -r -n 1 php -l
      '
    ;;
  smoke)
    port=$(python3 - <<'PY'
from pathlib import Path
values = dict(line.split('=', 1) for line in Path('.env').read_text().splitlines()
              if line and not line.startswith('#') and '=' in line)
print(values.get('WORDPRESS_PORT', '8080'))
PY
)
    temp=$(mktemp -d)
    trap 'rm -rf "$temp"' EXIT
    curl --fail --silent --show-error --max-time 20 "http://127.0.0.1:$port/" > "$temp/home.html"
    curl --fail --silent --show-error --max-time 20 "http://127.0.0.1:$port/wp-login.php" > "$temp/login.html"
    curl --fail --silent --show-error --max-time 20 "http://127.0.0.1:$port/?rest_route=/wp/v2/types" > "$temp/types.json"
    python3 - "$temp" <<'PY'
from pathlib import Path
import json, sys
path = Path(sys.argv[1])
home = (path / 'home.html').read_text()
assert '</html>' in home.lower(), 'Homepage did not render a complete document'
assert 'critical error' not in home.lower(), 'Homepage reports a fatal error'
assert 'id="loginform"' in (path / 'login.html').read_text(), 'Login form missing'
types = json.loads((path / 'types.json').read_text())
assert 'post' in types and 'page' in types, 'WordPress REST content types missing'
print('PASS: homepage, login form, and WordPress REST content types.')
PY
    ;;
  theme-smoke)
    "$0" smoke
    python3 scripts/theme-smoke.py
    ;;
  prepare-theme)
    for plugin in advanced-custom-fields/acf.php acf-repeater/acf-repeater.php acf-wordpress-wysiwyg-field-master/acf-wp_wysiwyg.php ikit/ikit.php; do
      if [ ! -f ".local/plugins/$plugin" ]; then
        echo "Missing local dependency: $plugin. Supply the matching site plugin ZIP; do not commit plugin code or credentials." >&2
        exit 1
      fi
    done
    wp --skip-themes --skip-plugins=ikit plugin activate advanced-custom-fields
    wp --skip-themes --skip-plugins=ikit plugin activate acf-repeater acf-wordpress-wysiwyg-field-master
    wp --skip-themes plugin activate ikit
    "$0" activate
    ;;
  activate)
    if ! wp --skip-plugins --skip-themes plugin is-active advanced-custom-fields; then
      echo 'Activate the matching Advanced Custom Fields plugin before iKit. The backup records ACF 4.4.7; iKit requires its acf_field class.' >&2
      exit 1
    fi
    wp --skip-themes eval '
      if (!class_exists("Ikit_Widget") || !function_exists("ikit_ssl_redirect") || !function_exists("ikit_style_editor_enqueue_style")) {
        WP_CLI::error("Install and activate the AIGA iKit plugin before activating these themes.");
      }
    '
    wp --skip-themes theme activate ikit_three_custom
    "$0" theme-smoke
    ;;
  *) echo 'Usage: scripts/dev.sh {setup|start|stop|lint|smoke|theme-smoke|prepare-theme|activate|wp [arguments...]}' >&2; exit 2 ;;
esac
