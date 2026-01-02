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
"display": "standalone",
"start_url": "{{ config('app.url') }}/backend",
"shortcuts": [
    {
        "name": "New Post",
        "short_name": "New Post",
        "description": "Create a new post",
        "url": "{{ route('backend.posts.create') }}",
        "icons": [{ "src": "{{ config('app.url') }}/web-app-manifest-192x192.png", "sizes": "192x192" }]
    },
    {
        "name": "New Photo",
        "short_name": "New Photo",
        "description": "Upload a new photo",
        "url": "{{ route('backend.photos.create') }}",
        "icons": [{ "src": "{{ config('app.url') }}/web-app-manifest-192x192.png", "sizes": "192x192" }]
    }
]
}
