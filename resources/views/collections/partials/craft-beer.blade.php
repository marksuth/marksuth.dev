<ul class="tile-grid tile-grid-lg">
@forelse($posts as $post)
                <li class="tile tile-inverse"><h2 class="tile-title">{{$post->title}}</h2> ({{$post->meta['beer_type']}}, {{$post->meta['beer_abv']}}%)<br>
                Brewery: {{$post->meta['brewery_name']}} ({{$post->meta['brewery_city']}}, {{$post->meta['brewery_country']}})<br>
                    My rating: {{$post->meta['rating']}}/5<br>
                    <a href="https://untappd.com/beer/{{$post->meta['untappd_id']}}" title="view on untappd"><i class="fa-brands fa-untappd" aria-label="View on Untappd"></i></a>
                </li>
@empty
                <p>No posts found</p>
@endforelse
</ul>
