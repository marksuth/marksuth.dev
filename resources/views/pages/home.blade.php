@extends('layouts.default' ,
['title' => 'Home',
'description' => 'Mark Sutherland is a Developer and Digital Creative based in Leicester, UK.']
)
@section('content')
    <section id="intro">
                <div class="h-card">
                    <h1 class="p-name">Mark Sutherland</h1>
                    <div class="post-box">
                        <p class="p-note box-mid">
                            <span class="p-locality">Leicester</span>,
                            <span class="p-country-name">UK</span>
                            <span class="p-pronouns box-divider">(He/Him)</span></p>
                        <nav id="social-links" class="elsewhere" aria-label="Social links">
                            <a class="u-url u-uid" href="{{ config('app.url') }}" rel="me" aria-label="Website"><i
                                    class="fa-solid fa-globe" aria-hidden="true"></i></a>
                            <a class="u-email" href="mailto:mark@marksuth.dev" rel="me" aria-label="Email"><i
                                    class="fa-solid fa-envelope" aria-hidden="true"></i></a>
                            <a href="https://github.com/marksuth" rel="me" aria-label="GitHub"><i
                                    class="fa-brands fa-github" aria-hidden="true"></i></a>
                            <a href="https://www.linkedin.com/in/marksuth" rel="me" aria-label="Linkedin"><i
                                    class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
                            <a href="https://mastodon.social/@marksuth" rel="me" aria-label="Mastodon"><i
                                    class="fa-brands fa-mastodon" aria-hidden="true"></i></a>
                            <a href="https://codepen.io/marksuth" rel="me" aria-label="CodePen"><i
                                    class="fa-brands fa-codepen" aria-hidden="true"></i></a>
                            <a href="https://bsky.app/profile/marksuth.dev" rel="me" aria-label="BlueSky"><i
                                    class="fa-brands fa-bluesky" aria-hidden="true"></i></a>
                            <a href="https://www.discogs.com/user/marksuth" rel="me" aria-label="Discogs"><i
                                    class="fa-solid fa-record-vinyl" aria-hidden="true"></i></a>
                            <a href="https://letterboxd.com/marksuth/" rel="me" aria-label="Letterboxd"><i
                                    class="fa-brands fa-letterboxd" aria-hidden="true"></i></a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
