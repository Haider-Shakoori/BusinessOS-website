#!/usr/bin/env python3
"""Build the single marketing CSS bundle used by the public layout."""
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
SOURCES = [
    ROOT / "public/assets/css/fonts.css",
    ROOT / "public/assets/css/businessos.css",
    ROOT / "public/assets/css/businessos-calm.css",
]
TARGET = ROOT / "public/assets/css/businessos.bundle.min.css"

def minify(css: str) -> str:
    css = re.sub(r"/\*[\s\S]*?\*/", "", css)
    css = re.sub(r"\s+", " ", css)
    css = re.sub(r"\s*([{}:;,])\s*", r"\1", css)
    css = css.replace(";}", "}")
    return css.strip()

TARGET.write_text(minify("\n".join(p.read_text() for p in SOURCES)))
print(f"Wrote {TARGET}")
