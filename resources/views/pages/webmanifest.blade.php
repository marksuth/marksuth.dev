{
"name": "{{ config('app.name') }}",
"short_name": "marksuth.dev",
"icons": [
{
"src": "{{ config('app.url') }}/icons/icon.svg",
"type": "image/svg+xml",
"sizes": "any",
"purpose": "any"
},
{
"src": "{{ config('app.url') }}/icons/icon-192.png",
"type": "image/png",
"sizes": "192x192"
},
{
"src": "{{ config('app.url') }}/icons/icon-512.png",
"type": "image/png",
"sizes": "512x512",
"purpose": "any"
}
],
"theme_color": "#214154",
"background_color": "#214154",
"display": "browser",
"start_url": "{{ config('app.url') }}"
}
