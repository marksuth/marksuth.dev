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
        @foreach($posts as $post)
        <item>
            <title>{{ $post->title }}</title>
            <link>https://marksuth.dev/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}</link>
            <pubDate>{{ $post->published_at->tz(env('APP_TIMEZONE'))->toRfc2822String() }}</pubDate>
            <description><![CDATA[<x-markdown>{{ $post->content }}</x-markdown>]]></description>
        </item>
        @endforeach
    </channel>
</rss>
