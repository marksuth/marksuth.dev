@extends('layouts.sitemap')
@section('sitemap')
    @foreach ($photos as $photo)
        <url>
            <loc>https://marksuth.dev/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}</loc>
            <lastmod>{{ $photo->published_at->tz(env('APP_TIMEZONE'))->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
@endsection
