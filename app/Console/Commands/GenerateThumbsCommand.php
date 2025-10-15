<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Exceptions\CouldNotLoadImage;
use Spatie\Image\Image;

final class GenerateThumbsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:generate-thumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for all photos that do not have img_thumb meta data.';

    /**
     * Execute the console command.
     *
     * @throws CouldNotLoadImage
     */
    public function handle(): void
    {
        $photos = Photo::all();

        foreach ($photos as $photo) {

            Image::load('storage/app/public/photos/'.$photo->meta['img_url'])
                ->quality(85)
                ->fit(Fit::Max, 2000, 2000)
                ->save();

            Image::load('storage/app/public/thumbs/'.$photo->meta['img_url'])
                ->fit(Fit::Crop, 500, 500)
                ->quality(85)
                ->save();

        }
    }
}
