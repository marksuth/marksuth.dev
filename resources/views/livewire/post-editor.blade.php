<div id="post-editor" class="tube">
    <form wire:submit="save">
        <div class="editor-grid">
            <div class="left-column">
                <div class="tile">
                    <div class="field">
                        <label for="title">Title</label>
                        <input type="text" id="title" wire:model.live="title">
                        @error('title') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" wire:model="slug">
                        @error('slug') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field"
                         x-data="{
                            easyMDE: null,
                            value: @entangle('content')
                         }"
                         x-init="
                            easyMDE = new EasyMDE({
                                element: $refs.editor,
                                initialValue: value
                            });
                            easyMDE.codemirror.on('change', () => {
                                value = easyMDE.value();
                            });
                         "
                         wire:ignore
                    >
                        <label for="content">Content</label>
                        <textarea id="content" x-ref="editor" wire:model="content"></textarea>
                        @error('content') <div class="error">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            <div class="right-column">
                <div class="tile">
                    <div class="field">
                        <label for="published_at">Publish Date</label>
                        <input type="datetime-local" id="published_at" wire:model="published_at">
                        @error('published_at') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="post_type_id">Post Type</label>
                        <select id="post_type_id" wire:model.live="post_type_id">
                            <option value="">Select Type</option>
                            @foreach($postTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('post_type_id') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    @if($post_type_id == 1)
                        <div class="field">
                            <label for="movie_url">Movie URL (Letterboxd)</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="text" id="movie_url" wire:model="movie_url" style="flex: 1;">
                                <button type="button" class="btn" wire:click="fetchMovieInfo">Fetch</button>
                            </div>
                            @if (session()->has('error'))
                                <div class="error">{{ session('error') }}</div>
                            @endif
                        </div>

                        <div class="field">
                            <label for="director">Director</label>
                            <input type="text" id="director" wire:model="director">
                        </div>

                        <div class="field">
                            <label for="released">Released Year</label>
                            <input type="text" id="released" wire:model="released">
                        </div>
                    @endif

                    <div class="checkbox-field">
                        <input type="checkbox" id="is_published" wire:model="is_published">
                        <label for="is_published">Published</label>
                    </div>

                    <div class="field">
                        <label for="image">Featured Image</label>
                        <input type="file" id="image" wire:model="image">
                        @error('image') <div class="error">{{ $message }}</div> @enderror
                        <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-2">Uploading...</div>
                        @if ($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" style="max-width: 100%; border-radius: 6px;">
                            </div>
                        @elseif ($post && isset($post->meta['img_url']))
                            <div class="mt-2">
                                <img src="{{ Storage::url(($post->post_type_id == 1 ? 'films/' : 'photos/') . $post->meta['img_url']) }}" alt="Current Image"
                                    style="max-width: 100%; border-radius: 6px;">
                            </div>
                        @elseif (!empty($slug) && $post_type_id == 1 && Storage::disk('public')->exists('films/' . $slug . '.jpg'))
                            <div class="mt-2">
                                <img src="{{ Storage::url('films/' . $slug . '.jpg') }}" alt="Fetched Poster"
                                    style="max-width: 100%; border-radius: 6px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn primary">{{ $post ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </div>
        </div>
    </form>
    @vite('resources/sass/easymde.scss')
</div>
