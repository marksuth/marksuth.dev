<div class="tube tube-content">
    @forelse($posts as $post)
        <article class="tile tile-inverse">
            <small><a href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>
                posted
                <time datetime="{{ $post->published_at }}">
                    @if($post->published_at->diffInWeeks(now()) < 6)
                        {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @else
                        {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                    @endif
                </time>
            </small>
            <h2><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}">
                    {{ $post->title }}</a></h2>
            <x-markdown>
                {!! Str::words("$post->content", 30, ' ...') !!}
            </x-markdown>
            <footer>

                <a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" class="btn btn-right" title="View {{ $post->post_type->name }}">View
                    {{ $post->post_type->name }} <i class="fa-solid fa-chevron-right"></i></a>
            </footer>
        </article>
        <hr>
    @empty
        <p>No posts found</p>
    @endforelse
        {{ $posts->links() }}
</div>
