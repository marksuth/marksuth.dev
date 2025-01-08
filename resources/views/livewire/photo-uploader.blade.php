<div>
    <form wire:submit.prevent="save">
        @if ($photo)
            Photo Preview:
            <img src="{{ $photo->temporaryUrl() }}" alt="image preview">
        @endif

        <input type="file" wire:model="photo">
            <div wire:loading wire:target="photo">Uploading <i class="fa-solid fa-spin fa-spinner"></i></div>


            @error('photo') <span class="error">{{ $message }}</span> @enderror

        <button type="submit">Save Photo</button>
    </form>

</div>
