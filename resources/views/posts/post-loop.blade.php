<div class="tube tube-content">
    <div class="h-feed">
        @forelse($posts as $post)
            <article class="post hentry h-entry">
                <small class="lozenge"><a class="p-category category"
                                          href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>
                    <time datetime="{{ $post->published_at }}" class="dt-published timestamp">
                        @if($post->published_at->diffInWeeks(now()) < 6)
                            {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                        @else
                            {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:i') }}
                        @endif
                    </time>
                </small>
                <h2 class="p-name"><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" class="u-url">
                        {{ $post->title }}</a></h2>
                <div class="e-content">
                    {!! Str::markdown(Str::words("$post->content", 30, ' ...')) !!}
                </div>
            </article>
        @empty
            <p>No posts found</p>
        @endforelse
        {{ $posts->links() }}
    </div>
</div>
