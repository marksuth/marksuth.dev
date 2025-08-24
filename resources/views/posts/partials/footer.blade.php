<footer class="entry-meta">
    <p><a href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>@if($post->distant_past != '1') posted @else imported @endif
        <time class="dt-published" datetime="{{ $post->published_at->tz(config('app.timezone'))->toRfc2822String() }}">{{ Carbon\Carbon::parse($post->published_at)->format('d/m/Y @ H:i') }}</time>
        by <span class="h-card"><img src="https://marksuth.dev/avatar.jpg" alt="Mark Sutherland" class="tiny-avatar u-photo" height="20" width="20" loading="lazy" /> <a href="https://marksuth.dev" class="p-author" rel="author">Mark Sutherland</a></span>
        @if($post->updated_at > $post->published_at)
        <br><i>Last updated <time class="dt-updated" datetime="{{ $post->updated_at->tz(config('app.timezone'))->toRfc2822String() }}">{{ Carbon\Carbon::parse($post->updated_at)->format('d/m/Y @ H:i') }}</time></i>
        @endif
    </p>
    <p>Posted to:
        &nbsp;<a href="@if (Str::startsWith($current = url()->current(), 'https://www')){{ str_replace('https://www.', 'https://', $current) }}@else{{ $current }}@endif" class="u-url"><i class="fa-solid fa-globe"></i></a>
    </p>
</footer>
