<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;

final class ImageUrlsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:filenames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for all photos that do not have img_thumb meta data.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $photos = Photo::all();

        foreach ($photos as $photo) {

            $image = str_replace('photos/', '', $photo->meta['img_url']);

            //            Image::load('storage/app/public/photos/' . $image)
            //                ->quality(85)
            //                ->fit(Fit::Max, 2000, 2000)
            //                ->save();
            //
            //            Image::load('storage/app/public/thumbs/' . $image)
            //                ->fit(Fit::Crop, 500, 500)
            //                ->quality(85)
            //                ->save();

            $meta = [];
            $meta['img_url'] = $image;
            $meta['location'] = $photo->meta['location'] ?? '';
            $meta['instagram_url'] = $photo->meta['instagram_url'] ?? '';
            $meta['published'] = $photo->meta['published'];
            $photo->meta = $meta;
            $photo->save();

        }
    }
}
