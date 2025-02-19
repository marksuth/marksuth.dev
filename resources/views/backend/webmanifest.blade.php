{
"short_name": "{{ config('app.name') }}",
"name": "{{ config('app.name') }}",
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
"id": "{{ config('app.url') }}/backend",
"start_url": "{{ config('app.url') }}/backend",
"background_color": "#214154",
"display": "standalone",
"scope": "{{ config('app.url') }}/backend",
"theme_color": "#214154",
"shortcuts": [
{
"name": "Upload Photo",
"short_name": "Photo",
"description": "Upload a new photo",
"url": "{{ config('app.url') }}/backend/photos/create"
},
{
"name": "New Post",
"short_name": "Post",
"description": "Upload a new Post",
"url": "{{ config('app.url') }}/backend/posts/create"
}
]
}
