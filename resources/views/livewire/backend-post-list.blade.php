<div>
    <form wire:submit.prevent="getPosts">
        <div class="row">
        <div class="col-md-3 mb-2">
            <input type="search" wire:model="search.title" class="form-control" placeholder="Search Posts">
        </div>
        <div class="col-md-3 mb-2">
            <select wire:model="search.type" class="form-select">
                <option value="">Select a type</option>
                @foreach($post_types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select wire:model="search.status" class="form-select">
                <option value="">Select a status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="scheduled">Scheduled</option>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <button type="submit" class="btn btn-primary mb-2" ><i class="fa-solid fa-search"></i></button>
        </div>

    </div>
    </form>

<div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="border-bottom">
                <tr><th scope="col">Type </th>
                    <th scope="col">Title</th>
                    <th class="col-3 text-end" scope="col">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td class="col-1">{{ $post->post_type->name }}</td>
                        <td><a href="{{ route('backend.posts.edit', $post->id) }}">{{ $post->title }}</a></td>
                        <td class="text-end small">
                            @if($post->published_at->diffInWeeks(now()) <= 6 && $post->meta['published'] == 1)
                                Published {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                            @elseif($post->published_at->isFuture() && $post->meta['published'] == 1)
                                Scheduled {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                            @elseif($post->published_at->diffInWeeks(now()) > 6 && $post->meta['published'] == 1)
                                Published {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:i') }}
                            @elseif($post->meta['published'] == 0)
                                Draft
                            @endif
                        </td>
                        <td class="col-2 text-end">
                            <a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" class="btn btn-outline-primary btn-sm" target="_blank"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('backend.posts.edit', $post->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-pen"></i></a>
                            <button wire:click="deletePost({{ $post->id }})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-5 text-center">No posts found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div>
<div class="my-3">
        {{ $posts->links() }}
</div>
</div>

