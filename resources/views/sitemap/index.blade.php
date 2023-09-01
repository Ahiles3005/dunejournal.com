<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('sitemap/news') }}</loc>
        <lastmod>{{ $news }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/categories') }}</loc>
        <lastmod>{{ $category }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/tags') }}</loc>
        <lastmod>{{ $tag }}</lastmod>
    </sitemap>
</sitemapindex>
