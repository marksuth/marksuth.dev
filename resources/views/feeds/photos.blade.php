@extends('layouts.feed')
@section('feed')
        @foreach($photos as $photo)
        <item>
            <title>{{ $photo->title }}</title>
            <author><![CDATA[mark@marksuth.dev (Mark Sutherland)]]></author>
            <link>{{ config('app.url') }}/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}</link>
            <pubDate>{{ $photo->published_at->tz(config('app.timezone'))->toRfc2822String() }}</pubDate>
            <description><![CDATA[
                <a href="{{ config('app.url') }}/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                    <img src="{{ Storage::url('photos/' . $photo->meta['img_url']) }}" alt="{{ $photo->title }}">
                </a>
                @if(isset($photo->meta['description']))
                <p>{{ $photo->meta['description'] }}</p>
                @endif
                @if(isset($photo->meta['location']))
                <p>Location: {{ $photo->meta['location'] }}</p>
                @endif
                ]]>
            </description>
            <guid>{{ config('app.url') }}/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}</guid>
        </item>
        @endforeach
@endsection
