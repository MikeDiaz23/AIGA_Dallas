#!/usr/bin/env python3
"""Check the active child theme, public page templates, and served source assets."""
from html.parser import HTMLParser
import json
from pathlib import Path
from urllib.parse import urlsplit
from urllib.request import HTTPRedirectHandler, ProxyHandler, build_opener

ROOT = Path(__file__).resolve().parent.parent
values = dict(
    line.split("=", 1)
    for line in (ROOT / ".env").read_text().splitlines()
    if line and not line.startswith("#") and "=" in line
)
port = int(values.get("WORDPRESS_PORT", "8080"))
assert 0 < port < 65536, "Invalid local WordPress port"
BASE = f"http://127.0.0.1:{port}"
class LocalRedirects(HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        target = urlsplit(newurl)
        if target.scheme != "http" or target.hostname not in ("127.0.0.1", "localhost") or target.port != port:
            raise ValueError("Refusing a redirect outside the local WordPress site")
        return super().redirect_request(req, fp, code, msg, headers, newurl)


# All requests stay on loopback; an external proxy is unnecessary here.
HTTP = build_opener(ProxyHandler({}), LocalRedirects())


def request(path):
    with HTTP.open(BASE + path, timeout=20) as response:
        assert response.status == 200, f"HTTP failure: {path}"
        assert urlsplit(response.url).hostname in ("127.0.0.1", "localhost"), "Unexpected external redirect"
        return response.read()


class Page(HTMLParser):
    def __init__(self):
        super().__init__()
        self.classes = set()
        self.assets = set()

    def handle_starttag(self, tag, attrs):
        attrs = dict(attrs)
        if tag == "body":
            self.classes = set(attrs.get("class", "").split())
        if tag == "script" and attrs.get("src"):
            self.assets.add(urlsplit(attrs["src"]).path)
        if tag == "link" and "stylesheet" in attrs.get("rel", ""):
            self.assets.add(urlsplit(attrs.get("href", "")).path)


def page(path, label):
    source = request(path).decode()
    parsed = Page()
    parsed.feed(source)
    assert "wp-child-theme-ikit_three_custom" in parsed.classes, "iKit child theme is not active"
    assert "</html>" in source.lower() and "critical error" not in source.lower(), f"Incomplete page: {label}"
    print(f"PASS: {label} renders the iKit child theme")
    return parsed


home = page("/", "homepage")
for endpoint, query, marker in (
    ("pages", "page_id", "page-id"),
    ("posts", "p", "postid"),
):
    published = json.loads(request(f"/?rest_route=/wp/v2/{endpoint}&per_page=1&_fields=id"))
    assert isinstance(published, list), f"REST {endpoint} query failed"
    if not published:
        print(f"SKIP: no published {endpoint} available for a template request")
        continue
    identifier = int(published[0]["id"])
    parsed = page(f"/?{query}={identifier}", f"published {endpoint} template")
    assert f"{marker}-{identifier}" in parsed.classes, "Requested content did not render"

for relative in (
    "ikit_three/style.css",
    "ikit_three_custom/style.css",
    "ikit_three_custom/.style_editor/css/stylesheets/background_images.css",
    "ikit_three_custom/.style_editor/css/stylesheets/sass.css",
    "ikit_three_custom/.style_editor/css/stylesheets/sass_templates.css",
    "ikit_three/js/ikit_three.js",
):
    path = "/wp-content/themes/" + relative
    assert path in home.assets, f"Required theme asset missing from homepage: {relative}"
    assert request(path) == (ROOT / "themes" / relative).read_bytes(), f"Served source differs: {relative}"
    print(f"PASS: served asset matches repository: {relative}")
