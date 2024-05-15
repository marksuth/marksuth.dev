@extends('layouts.sitemap')
@section('sitemap')
    @foreach ($posts as $post)
        <url>
            <loc>https://marksuth.dev/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}</loc>
            <lastmod>{{ $post->published_at->tz(env('APP_TIMEZONE'))->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach($types as $type)
        @if($type->count > 0)
        <url>
            <loc>https://marksuth.dev/posts/type/{{ strtolower($type->name) }}</loc>
            <lastmod>{{ $latest->updated_at->tz(env('APP_TIMEZONE'))->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endif
    @endforeach
@endsection
