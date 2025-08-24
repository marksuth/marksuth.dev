@extends('layouts.sitemap')
@section('sitemap')
        <url>
            <loc>https://marksuth.dev/</loc>
            <lastmod>2022-04-10T19:21:31+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>https://marksuth.dev/posts</loc>
            <lastmod>2022-04-10T19:21:31+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
        <url>
            <loc>https://marksuth.dev/photos</loc>
            <lastmod>2022-04-10T19:21:31+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
        <url>
            <loc>https://marksuth.dev/stream</loc>
            <lastmod>2022-04-10T19:21:31+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @foreach ($pages as $page)
        <url>
            <loc>https://marksuth.dev/{{ $page->slug }}</loc>
            <lastmod>{{ $page->updated_at->tz(config('app.timezone'))->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
@endsection
