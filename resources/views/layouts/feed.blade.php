<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="https://marksuth.dev/feed/posts" rel="self" type="application/rss+xml" />
        <title><![CDATA[Mark Sutherland]]></title>
        <image>
            <url><![CDATA[https://marksuth.dev/images/avatar.jpg]]></url>
            <title><![CDATA[Mark Sutherland]]></title>
            <link><![CDATA[https://marksuth.dev/]]></link>
        </image>
        <link><![CDATA[https://marksuth.dev/feed/posts]]></link>
        <description><![CDATA[Web Developer based in Leicester, UK]]></description>
        <language>en-GB</language>
        @yield('feed')
    </channel>
</rss>
