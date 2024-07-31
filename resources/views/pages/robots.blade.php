@env('staging')
User-agent: *
Disallow: /
@endenv
@production
User-agent: *
Allow: /

Sitemap: {{ config('app.url') }}/sitemap.xml
@endproduction
