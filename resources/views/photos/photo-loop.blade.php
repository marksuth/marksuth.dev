<ul class="tile-grid">
    @forelse($photos as $photo)
        <li class="tile">
            <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}" height="500" width="500">
            </a>
            <time datetime="{{ $photo->published_at }}">
                @if($photo->published_at->diffInWeeks(now()) < 6)
                    {{ $photo->published_at->tz(config('app.timezone'))->diffForHumans() }}
                @else
                    {{ $photo->published_at->tz(config('app.timezone'))->format('d/m/y @ H:i') }}
                @endif
            </time>
        </li>
    @empty
        <p>No photos found</p>
    @endforelse
</ul>
