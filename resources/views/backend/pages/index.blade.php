@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>Pages</h1>
        <div>
            <a href="{{ route('backend.pages.create') }}" class="btn btn-primary">New Page</a>
        </div>
    </div>
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th class="col-8" scope="col">Title</th>
            <th class="col-3 text-end" scope="col">Status</th>
            <th class="col-1" scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td><a href="{{ route('backend.pages.edit', $page->id) }}">{{ $page->title }}</a></td>
                <td class="text-end">
                    @if($page->published_at->diffInWeeks(now()) <= 6 && $page->meta['published'] == 1)
                        Published {{ $page->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @elseif($page->published_at->isFuture() && $page->meta['published'] == 1)
                        Scheduled {{ $page->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @elseif($page->published_at->diffInWeeks(now()) > 6 && $page->meta['published'] == 1)
                        Published {{ $page->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:i') }}
                    @elseif($page->meta['published'] == 0)
                        Draft
                    @endif
                </td>
                <td class="text-end">
                    <a href="/{{ $page->slug }}" target="blank">View</a>
                    <a href="{{ route('backend.pages.edit', $page->id) }}">Edit</a></td>
            </tr>
        @empty
            <p>No pages found</p>
        @endforelse
        </tbody>
    </table>
@endsection
