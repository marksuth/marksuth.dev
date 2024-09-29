<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class BackendPostController extends Controller
{
    public function index(): View|Factory|Application
    {
        $posts = Post::whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('created_at')
            ->paginate(20);

        return view('backend.posts.index', compact('posts'));
    }

    public function create(): View|Factory|Application
    {
        $post_types = PostType::whereNotIn('id', [49, 50, 51])->get();

        return view('backend.posts.post', compact('post_types'));
    }

    public function store(): Application|Redirector|RedirectResponse
    {
        $post = new Post;

        $post->title = request('title');
        $post->slug = Str::slug(request('title'));
        $post->content = request('content');
        $post->published_at = request('published_at');
        $post->post_type_id = request('type');

        $meta = [];
        $meta['description'] = request('description');
        $meta['web_url'] = request('web_url');
        $meta['medium_url'] = request('medium_url');
        $meta['twitter_url'] = request('twitter_url');
        $meta['instagram_url'] = request('linkedin_url');
        $meta['facebook_url'] = request('facebook_url');
        $meta['published'] = request('published');
        $meta['distant_past'] = request('distant_past');
        $meta['near_future'] = request('near_future');

        $post->meta = $meta;

        $post->save();

        return redirect('/backend/posts');
    }

    public function edit($id): View|Factory|Application
    {
        $post = Post::find($id);
        $post_types = PostType::whereNotIn('id', [49, 50, 51])->get();

        return view('backend.posts.post', compact('post', 'post_types'));
    }

    public function update($id): Application|Redirector|RedirectResponse
    {

        $post = Post::find($id);

        $post->title = request('title');
        $post->slug = Str::slug(request('title'));
        $post->content = request('content');
        $post->published_at = request('published_at');
        $post->post_type_id = request('type');

        $meta = [];
        $meta['description'] = request('description');
        $meta['web_url'] = request('web_url');
        $meta['medium_url'] = request('medium_url');
        $meta['untappd_url'] = request('untappd_url');
        $meta['twitter_url'] = request('twitter_url');
        $meta['instagram_url'] = request('linkedin_url');
        $meta['facebook_url'] = request('facebook_url');
        $meta['published'] = request('published') ? 1 : 0;
        $meta['distant_past'] = request('distant_past') ? 1 : 0;
        $meta['near_future'] = request('near_future') ? 1 : 0;
        $meta['img_url'] = request('image')->store('public/photos');
        $meta['img_url'] = str_replace('public/', '', $meta['img_url']);

        $post->meta = $meta;

        $post->save();

        return redirect('/backend/posts');
    }

    public function destroy($id): Application|Redirector|RedirectResponse
    {
        $post = Post::find($id);

        $post->delete();

        return redirect('/backend/posts');
    }
}
