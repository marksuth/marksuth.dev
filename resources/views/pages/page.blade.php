@extends('layouts.default',
[
    'title' => Str::limit($page->title, 32, '...'),
    'description' => $page->metadescription ?? $page->title .', by '. env('APP_NAME') .', a Web Developer based in Leicester, UK.',
])
@section('content')
    <article class="h-entry hentry">
        <header class="page-header">
            <h1 class="p-name fancy-title">{{ $page->title }}</h1>
        </header>
        <div class="post entry-content post-box">
            {!! Str::markdown($page->content) !!}
        </div>
    </article>
@endsection
