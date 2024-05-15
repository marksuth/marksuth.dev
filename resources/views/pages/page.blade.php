@extends('layouts.default',
[
    'title' => Str::limit($page->title, 32, '...'),
    'description' => $page->metadescription ?? $page->title . ", by " . env('APP_NAME') . ", a Web Developer based in Leicester, UK.",
])
@section('title')
    {{ Str::limit($page->title, 32, '...') }}
@endsection
@section('content')
    <article class="h-entry hentry">
        <header class="page-header">
            <h1 class="page-title">{{ $page->title }}</h1>
        </header>
        <div class="post">
            <x-markdown class="entry-content">
                {!! $page->content !!}
            </x-markdown>
        </div>
    </article>
@endsection
