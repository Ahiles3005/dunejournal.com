<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($news as $new)
        <url>
            <loc>{{url("article",$new->slug)}}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP', strtotime($new->created_at))}}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>
