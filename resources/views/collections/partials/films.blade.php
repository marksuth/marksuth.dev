<ul class="tile-grid">
    @forelse($posts as $post)
                <li class="tile tile-media">
                    <img src="/storage/photos/{{$post->meta['img_url']}}" alt="{{$post->title}}">
                    <div class="details">
                    <h2 class="tile-title">{{$post->title}}</h2>
                <p>Released: {{$post->meta['released']}}<br>
                        Director: {{$post->meta['director']}}<br>
                    <a href="{{$post->meta['letterboxd_url']}}" title="view on Letterboxd"><i class="fa-brands fa-square-letterboxd"></i></a>
                    </p>
                    </div>
                </li>
@empty
                <p>No posts found</p>
@endforelse
</ul>
