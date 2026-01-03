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

                    <div class="field">
                        <label for="content">Content</label>
                        <textarea id="content" wire:model="content"></textarea>
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
                        <select id="post_type_id" wire:model="post_type_id">
                            <option value="">Select Type</option>
                            @foreach($postTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('post_type_id') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="checkbox-field">
                        <input type="checkbox" id="is_published" wire:model="is_published">
                        <label for="is_published">Publish Immediately</label>
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
                                <img src="{{ Storage::url('photos/' . $post->meta['img_url']) }}" alt="Current Image"
                                    style="max-width: 100%; border-radius: 6px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn primary">{{ $post ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
