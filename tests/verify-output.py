"""Check template-owned links in a real phpDocumentor build."""

import hashlib
from html.parser import HTMLParser
from pathlib import Path
import sys
from urllib.parse import unquote, urljoin, urlsplit


class Page(HTMLParser):
    def __init__(self):
        super().__init__()
        self.base = "./"
        self.assets = []
        self.anchors = []
        self.ids = set()
        self.search_label = False

    def handle_starttag(self, tag, attrs):
        attrs = dict(attrs)
        if attrs.get("id"):
            self.ids.add(attrs["id"])
        if tag == "base":
            self.base = attrs["href"]
        if tag in {"img", "script"} and attrs.get("src"):
            self.assets.append(attrs["src"])
        if tag == "link" and attrs.get("href"):
            self.assets.append(attrs["href"])
        if tag == "a" and (
            attrs.get("class") == "ff-skip-link"
            or attrs.get("id") == "back-to-top"
        ):
            self.anchors.append(attrs["href"])
        if tag == "input" and attrs.get("type") == "search":
            self.search_label = attrs.get("aria-label") == "Search documentation"


def verify(output):
    pages = sorted(output.rglob("*.html"))
    assert pages, "No generated HTML"
    for source in pages:
        page = Page()
        page.feed(source.read_text())
        assert page.search_label, f"Search label missing: {source}"
        assert "content" in page.ids, f"Reading target missing: {source}"
        base = urljoin(source.as_uri(), page.base)
        for href in page.assets:
            # Graph artifacts depend on the consumer's optional Graph writer.
            # This check owns the shared CSS, JavaScript and identity assets.
            if not href.startswith(("css/", "js/", "images/")):
                continue
            target = urlsplit(urljoin(base, href))
            if target.scheme != "file":
                continue
            assert Path(unquote(target.path)).is_file(), f"Missing asset: {href} in {source}"
        assert len(page.anchors) == 2, f"Reading anchors missing: {source}"
        for href in page.anchors:
            target = urlsplit(urljoin(base, href))
            assert Path(unquote(target.path)) == source, f"Reading anchor leaves page: {href}"
            assert target.fragment in page.ids, f"Reading anchor is missing: {href}"

    template = Path(__file__).resolve().parents[1]
    for name in ("fast-forward-logo-dark.svg", "dash-reading.png"):
        original = (template / "docs/_static" / name).read_bytes()
        generated = (output / "images" / name).read_bytes()
        assert hashlib.sha256(original).digest() == hashlib.sha256(generated).digest(), name
    assert (output / "guides/installation.html").is_file(), "Nested guide not generated"
    assert (output / "classes/FastForward-Documentation-Example.html").is_file(), "API not generated"
    print(f"PASS: {len(pages)} generated pages, nested reading anchors and byte-identical assets")


if __name__ == "__main__":
    verify(Path(sys.argv[1]).resolve())
