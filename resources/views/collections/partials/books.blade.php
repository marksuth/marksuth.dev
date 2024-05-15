<ul class="tile-grid tile-grid-lg">
    @forelse($posts as $post)
        <li class="tile tile-inverse">
            <p><strong>{{$post->title}}</strong><br>
                {{$post->meta['book_author']}}<br><small class="status">{{$post->meta['book_status']}}</small></p>
        </li>
    @empty
        <p>No posts found</p>
    @endforelse
</ul>
