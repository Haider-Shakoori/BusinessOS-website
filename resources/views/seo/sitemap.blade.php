<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($urls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
        <lastmod>{{ $url['lastmod'] }}</lastmod>
        <priority>{{ $url['priority'] }}</priority>
        <xhtml:link rel="alternate" hreflang="en" href="{{ $url['loc'] }}"/>
        @if($url['localized'] ?? false)
            <xhtml:link rel="alternate" hreflang="fa-AF" href="{{ $url['loc'] }}?lang=fa"/>
            <xhtml:link rel="alternate" hreflang="ps-AF" href="{{ $url['loc'] }}?lang=ps"/>
        @endif
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $url['loc'] }}"/>
        @foreach($url['images'] ?? [] as $image)
            <image:image>
                <image:loc>{{ $image['loc'] }}</image:loc>
                @if($image['title'])<image:title>{{ $image['title'] }}</image:title>@endif
                @if($image['caption'])<image:caption>{{ $image['caption'] }}</image:caption>@endif
            </image:image>
        @endforeach
    </url>
@endforeach
</urlset>
