@extends('layouts.feed')
@section('feed')
        @foreach($posts as $post)
        <item>
            <title>{{ $post->title }}</title>
            <author><![CDATA[mark@marksuth.dev (Mark Sutherland)]]></author>
            <link>{{ config('app.url') }}/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}</link>
            <pubDate>{{ $post->published_at->tz(config('app.timezone'))->toRfc2822String() }}</pubDate>
            <description>{{ Str::markdown($post->content) }}</description>
            <guid>{{ config('app.url') }}/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}</guid>
        </item>
        @endforeach
@endsection
