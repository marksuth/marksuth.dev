@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <h1>Pages</h1>
    <a href="{{ route('backend.pages.create') }}" class="btn btn-primary">New Page</a>
    <table>
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td><a href="{{ route('backend.pages.edit', $page->id) }}">{{ $page->title }}</a></td>
                <td>
                    @if($page->published_at->diffInWeeks(now()) <= 6 && $page->meta['published'] == 1)
                        Published {{ $page->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @elseif($page->published_at->isFuture() && $page->meta['published'] == 1)
                        Scheduled {{ $page->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @elseif($page->published_at->diffInWeeks(now()) > 6 && $page->meta['published'] == 1)
                        Published {{ $page->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                    @elseif($page->meta['published'] == 0)
                        Draft
                    @endif
                </td>
                <td>
                    <a href="/{{ $page->slug }}" target="blank">View</a>
                    <a href="{{ route('backend.pages.edit', $page->id) }}">Edit</a></td>
            </tr>
        @empty
            <p>No pages found</p>
        @endforelse
        </tbody>
    </table>
@endsection
