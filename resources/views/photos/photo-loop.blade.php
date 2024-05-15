<ul class="tile-grid">
    @forelse($photos as $photo)
        <li class="tile">
            <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}" height="500" width="500">
            </a>
            <time datetime="{{ $photo->published_at }}">
                @if($photo->published_at->diffInWeeks(now()) < 6)
                    {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                @else
                    {{ $photo->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                @endif
            </time>
        </li>
    @empty
        <p>No photos found</p>
    @endforelse
</ul>
