<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($urls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
        <lastmod>{{ $url['lastmod'] }}</lastmod>
        <priority>{{ $url['priority'] }}</priority>
        <xhtml:link rel="alternate" hreflang="en" href="{{ $url['loc'] }}"/>
        <xhtml:link rel="alternate" hreflang="fa-AF" href="{{ $url['loc'] }}?lang=fa"/>
        <xhtml:link rel="alternate" hreflang="ps-AF" href="{{ $url['loc'] }}?lang=ps"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $url['loc'] }}"/>
    </url>
@endforeach
</urlset>
