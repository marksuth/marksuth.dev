<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ config('app.url') }}/sitemap_pages.xml</loc>
    </sitemap>
    <sitemap>
        <loc>{{ config('app.url') }}/sitemap_posts.xml</loc>
    </sitemap>
    <sitemap>
        <loc>{{ config('app.url') }}/sitemap_photos.xml</loc>
    </sitemap>
</sitemapindex>
