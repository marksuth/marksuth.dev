<div class="tube tube-content">
    <div class="h-feed">
            @forelse($posts as $post)
                <article class="post hentry h-entry">
                    @if($post->postType)
                        <small class="lozenge">
                            <a class="p-category category"
                               href="{{ route('posts.type', $post->postType->slug) }}">{{ $post->postType->name }}</a>
                            <time datetime="{{ $post->published_at->toIso8601String() }}" class="dt-published timestamp">
                                @if($post->published_at->diffInWeeks(now()) < 6)
                                    {{ $post->published_at->tz(config('app.timezone'))->diffForHumans() }}
                                @else
                                    {{ $post->published_at->tz(config('app.timezone'))->format('d/m/y @ H:i') }}
                                @endif
                            </time>
                        </small>
                    @endif
                    <h2 class="p-name">
                        <a href="{{ route('posts.show', ['year' => $post->published_at->format('Y'), 'month' => $post->published_at->format('m'), 'slug' => $post->slug]) }}"
                           class="u-url">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <div class="e-content">
                        {!! Str::markdown(Str::words((string) $post->content, 30, ' ...')) !!}
                    </div>
                </article>
                <hr />
            @empty
                <p>No posts found</p>
            @endforelse
            {{ $posts->links() }}
        </div>
    </div>
