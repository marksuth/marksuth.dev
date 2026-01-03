<div class="photo-editor">
    <div class="header">
        <h2>Upload Photos & Videos</h2>
        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress" class="upload-area">
            <input type="file" wire:model="uploads" multiple accept="image/*,video/*">

            <div x-show="!isUploading">
                <p class="upload-text">Drag and drop files here or click to upload</p>
                <p class="upload-subtext">Images and short videos supported</p>
            </div>

            <div x-show="isUploading" class="progress-container">
                <p class="progress-label">Uploading...</p>
                <div class="progress-track">
                    <div class="progress-bar" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        </div>
        @error('uploads.*') <span class="error">{{ $message }}</span> @enderror

        @if($uploads)
            <div class="pending-uploads">
                <h3>Pending Uploads</h3>
                @foreach($uploads as $index => $upload)
                    <div class="field-group" wire:key="pending-{{ $index }}">
                        <div class="field">
                            <label>Name (for {{ $upload->getClientOriginalName() }})</label>
                            <input type="text" wire:model="uploadData.{{ $index }}.title">
                            @error('uploadData.'.$index.'.title') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field">
                            <label>Location</label>
                            <input type="text" wire:model="uploadData.{{ $index }}.location" placeholder="e.g. London, UK">
                            @error('uploadData.'.$index.'.location') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field">
                            <label>Published At</label>
                            <input type="datetime-local" wire:model="uploadData.{{ $index }}.published_at">
                            @error('uploadData.'.$index.'.published_at') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field">
                            <label>Album</label>
                            <select wire:model="uploadData.{{ $index }}.album_id">
                                <option value="">No Album</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->title }}</option>
                                @endforeach
                            </select>
                            @error('uploadData.'.$index.'.album_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field">
                            <label>Or Create New Album</label>
                            <input type="text" wire:model="uploadData.{{ $index }}.new_album_name" placeholder="Album name">
                            @error('uploadData.'.$index.'.new_album_name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endforeach
                <div class="actions">
                    <button wire:click="saveUploads" class="btn primary">Save All Uploads</button>
                </div>
            </div>
        @endif
    </div>

    <div class="tile-grid">
        @forelse($photos as $photo)
            <div class="tile tile-sm">
                <div class="media-container">
                    @if(Str::startsWith($photo->meta['mime_type'] ?? '', 'video'))
                        <video src="{{ Storage::url('photos/' . ($photo->meta['img_url'] ?? '')) }}" class="media" controls></video>
                    @else
                        <img src="{{ Storage::url('photos/' . ($photo->meta['img_url'] ?? '')) }}" alt="{{ $photo->title }}" class="media">
                    @endif

                    <div class="overlay">
                        <button wire:click="edit({{ $photo->id }})" class="btn primary">Edit</button>
                        <button wire:click="delete({{ $photo->id }})" wire:confirm="Are you sure?"
                            class="btn danger">Delete</button>
                    </div>
                </div>
                <div class="content">
                    <p title="{{ $photo->title }}">{{ $photo->title }}</p>
                    <div class="meta-row">
                        <small class="date">{{ $photo->published_at ? $photo->published_at->diffForHumans() : $photo->created_at->diffForHumans() }}</small>
                        @if($photo->album)
                            <small class="album-tag">{{ $photo->album->title }}</small>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>No photos found.</p>
        @endforelse
    </div>

    <div class="pagination">
        {{ $photos->links() }}
    </div>

    @if($showEditModal)
        <div class="modal-wrap">
            <div class="modal modal-lg">
                <div class="modal-grid">
                    <div class="modal-sidebar">
                        @if($editingPhoto)
                            @if(Str::startsWith($editingPhoto->meta['mime_type'] ?? '', 'video'))
                                <video src="{{ Storage::url('photos/' . ($editingPhoto->meta['img_url'] ?? '')) }}" class="media-preview" controls></video>
                            @else
                                <img src="{{ Storage::url('photos/' . ($editingPhoto->meta['img_url'] ?? '')) }}" alt="{{ $editingPhoto->title }}" class="media-preview">
                            @endif
                        @endif
                    </div>

                    <div class="modal-content-form">
                        <h3>Edit Photo</h3>

                        <div class="space-y-4">
                            <div class="field">
                                <label>Title</label>
                                <input type="text" wire:model="editTitle">
                                @error('editTitle') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label>Caption / Content</label>
                                <textarea wire:model="editContent" rows="3"></textarea>
                                @error('editContent') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label>Location</label>
                                <input type="text" wire:model="editLocation">
                                @error('editLocation') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label>Published At</label>
                                <input type="datetime-local" wire:model="editPublishedAt">
                                @error('editPublishedAt') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label>Album</label>
                                <select wire:model="editAlbumId">
                                    <option value="">No Album</option>
                                    @foreach($albums as $album)
                                        <option value="{{ $album->id }}">{{ $album->title }}</option>
                                    @endforeach
                                </select>
                                @error('editAlbumId') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label>Or Create New Album</label>
                                <input type="text" wire:model="editNewAlbumName" placeholder="Album name">
                                @error('editNewAlbumName') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="actions">
                            <button wire:click="cancelEdit" class="btn secondary">Cancel</button>
                            <button wire:click="update" class="btn primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
