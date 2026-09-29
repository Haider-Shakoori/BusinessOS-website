#!/usr/bin/env python3
"""Build the single marketing CSS bundle used by the public layout.

The minifier only removes comments and whitespace outside quoted strings, so it
does not change CSS string/content values.
"""
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SOURCES = [
    ROOT / "public/assets/css/fonts.css",
    ROOT / "public/assets/css/businessos.css",
    ROOT / "public/assets/css/businessos-calm.css",
]
TARGET = ROOT / "public/assets/css/businessos.bundle.min.css"

def minify(css: str) -> str:
    out = []
    quote = None
    in_comment = False
    pending_space = False
    i = 0

    while i < len(css):
        char = css[i]
        nxt = css[i + 1] if i + 1 < len(css) else ""

        if in_comment:
            if char == "*" and nxt == "/":
                in_comment = False
                i += 2
                continue
            i += 1
            continue

        if quote is None and char == "/" and nxt == "*":
            in_comment = True
            i += 2
            continue

        if quote is not None:
            out.append(char)
            if char == "\\" and i + 1 < len(css):
                out.append(css[i + 1])
                i += 2
                continue
            if char == quote:
                quote = None
            i += 1
            continue

        if char in ("'", '"'):
            if pending_space and out and out[-1] not in "{(:,;":
                out.append(" ")
            pending_space = False
            quote = char
            out.append(char)
            i += 1
            continue

        if char.isspace():
            pending_space = True
            i += 1
            continue

        if char in "{}:;,":
            if out and out[-1] == " ":
                out.pop()
            out.append(char)
            pending_space = False
            i += 1
            continue

        if pending_space:
            prev = out[-1] if out else ""
            if prev and prev not in "{(:,;" and char not in "}),;:":
                out.append(" ")
            pending_space = False

        out.append(char)
        i += 1

    return "".join(out).replace(";}", "}").strip()

TARGET.write_text(minify("\n".join(path.read_text() for path in SOURCES)))
print(f"Wrote {TARGET}")
