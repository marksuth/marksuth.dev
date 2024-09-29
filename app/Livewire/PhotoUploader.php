<?php

namespace App\Livewire;

use Dotenv\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoUploader extends Component
{
    use WithFileUploads;

    public string $photo;

    public function save(): void
    {

        Validator::make(
            ['photo' => $this->photo],
            ['photo' => 'image|max:1024'],
        )->validate();

        $this->photo->store('photos');

    }
}
