{
"name": "{{ config('app.name') }}",
"short_name": "{{ config('app.name') }}",
"icons": [
{
"src": "{{ config('app.url') }}/web-app-manifest-192x192.png",
"sizes": "192x192",
"type": "image/png",
"purpose": "maskable"
},
{
"src": "{{ config('app.url') }}/web-app-manifest-512x512.png",
"sizes": "512x512",
"type": "image/png",
"purpose": "maskable"
}
],
"theme_color": "#214154",
"background_color": "#eeeeee",
"display": "browser",
"start_url": "{{ config('app.url') }}"
}
