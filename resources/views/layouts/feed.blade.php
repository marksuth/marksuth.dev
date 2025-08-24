<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="{{ config('app.url') }}" rel="self" type="application/rss+xml" />
        <title><![CDATA[Mark Sutherland]]></title>
        <link><![CDATA[{{ config('app.url') }}]]></link>
        <image>
            <url><![CDATA[{{ config('app.url') }}/avatar.jpg]]></url>
            <title><![CDATA[Mark Sutherland]]></title>
            <link><![CDATA[{{ config('app.url') }}]]></link>
        </image>
        <description><![CDATA[Web Developer based in Leicester, UK]]></description>
        <language>en-gb</language>
        <pubDate>{{ $latest->published_at->tz(config('app.timezone'))->toRfc2822String() }}</pubDate>
        @yield('feed')
    </channel>
</rss>
