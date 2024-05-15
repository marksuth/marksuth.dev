<ul class="tile-grid">
            @forelse($posts as $post)
                <li class="tile">
                        @if(isset($post->meta['img_url']))
                                <img loading="lazy" src="/storage/{{ $post->meta['img_url'] }}" alt="{{ $post->title }}"
                                     height="700" width="700">
                        @else
                            <div class="text-center py-5">
                                <i class="fa-solid fa-record-vinyl fa-5x py-5"></i>
                            </div>
                        @endif
                        <h2 class="h5">{{$post->title}}</h2>
                        <p>{{$post->meta['artist']}}<br>
                            <small>Released {{$post->meta['year']}}</small></p>
                        <nav class="nav">
                            <a href="https://www.discogs.com/release/{{$post->meta['discogs']}}"
                               title="View on Discogs"><i class="fa-solid fa-record-vinyl"></i></a>
                            @if(isset($post->meta['spotify']))
                                <a href="{{$post->meta['spotify']}}" title="Listen on Spotify"><i
                                        class="fa-brands fa-spotify mx-1"></i></a>
                            @endif
                        </nav>
                </li>
            @empty
                <p>No photos found</p>
            @endforelse

</ul>
