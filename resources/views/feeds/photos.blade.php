<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="https://marksuth.dev" rel="self" type="application/rss+xml" />
        <title><![CDATA[Mark Sutherland]]></title>
        <link><![CDATA[https://marksuth.dev]]></link>
        <image>
            <url><![CDATA[https://marksuth.dev/images/avatar.jpg]]></url>
            <title><![CDATA[Mark Sutherland]]></title>
            <link><![CDATA[https://marksuth.dev]]></link>
        </image>
        <description><![CDATA[Web Developer based in Leicester, UK]]></description>
        <pubDate>{{ $latest->published_at->tz(env('APP_TIMEZONE'))->toRfc2822String() }}</pubDate>
        @foreach($photos as $photo)
        <item>
            <title>{{ $photo->title }}</title>
            <link>https://marksuth.dev/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}</link>
            <pubDate>{{ $photo->published_at->tz(env('APP_TIMEZONE'))->toRfc2822String() }}</pubDate>
            <description>
                <a href="https://marksuth.dev/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                    <img src="https://marksuth.dev/storage/photos/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}" />
                </a>
                @if(isset($photo->meta['description']))
                <p>{{ $photo->meta['description'] }}</p>
                @endif
                @if(isset($photo->meta['location']))
                <p>Location: {{ $photo->meta['location'] }}</p>
                @endif
            </description>
        </item>
        @endforeach
    </channel>
</rss>
