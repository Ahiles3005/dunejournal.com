<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($tags as $tag)
        <url>
            <loc>{{ url('/list/tag', $tag->slug) }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
