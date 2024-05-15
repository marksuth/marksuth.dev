@extends('layouts.default',
[
    'title' => Str::limit($page->title, 32, '...'),
    'description' => $page->metadescription ?? $page->title . ", by " . env('APP_NAME') . ", a Web Developer based in Leicester, UK.",
])
@section('title')
{{ Str::limit($page->title, 32, '...') }}
@endsection
@if($page->metadescription)
@section('metadescription', $page->metadescription )
@else
@section('metadescription', $page->title . ", by " . env('APP_NAME') . ", a Web
Developer based in Leicester, UK.")
@endif
@section('content')
            <article class="h-entry hentry">
                <header class="page-header">
                    <div class="page-title">
                        <h1>{{ $page->title }}</h1>
                    </div>
                </header>
                <div class="post">
                        <x-markdown class="entry-content">
                            {!! $page->content !!}
                        </x-markdown>
                        </div>
            </article>
            @endsection
