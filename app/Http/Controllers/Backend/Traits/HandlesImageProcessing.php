<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Exceptions\CouldNotLoadImage;
use Spatie\Image\Image;

trait HandlesImageProcessing
{
    /**
     * Process and store an uploaded image.
     *
     * @param  UploadedFile  $file  The uploaded file
     * @param  string  $path  The storage path
     * @param  int  $quality  The image quality (0-100)
     * @param  int  $maxWidth  Maximum width
     * @param  int  $maxHeight  Maximum height
     * @return string The stored image path
     *
     * @throws CouldNotLoadImage
     */
    protected function processAndStoreImage(
        UploadedFile $file,
        string $path = 'public/photos',
        int $quality = 85,
        int $maxWidth = 2000,
        int $maxHeight = 2000
    ): string {
        $storedPath = $file->store($path);

        Image::load(storage_path('app/'.$storedPath))
            ->quality($quality)
            ->fit(Fit::Max, $maxWidth, $maxHeight)
            ->save();

        return $storedPath;
    }

    /**
     * Create a thumbnail from an uploaded image.
     *
     * @param  UploadedFile  $file  The uploaded file
     * @param  string  $path  The storage path
     * @param  int  $width  Thumbnail width
     * @param  int  $height  Thumbnail height
     * @param  int  $quality  The image quality (0-100)
     * @return string The stored thumbnail path
     *
     * @throws CouldNotLoadImage
     */
    protected function createThumbnail(
        UploadedFile $file,
        string $path = 'public/thumbs',
        int $width = 500,
        int $height = 500,
        int $quality = 85
    ): string {
        $storedPath = $file->store($path);

        Image::load(storage_path('app/'.$storedPath))
            ->fit(Fit::Crop, $width, $height)
            ->quality($quality)
            ->save();

        return $storedPath;
    }

    /**
     * Get the public URL for a stored image.
     *
     * @param  string  $path  The stored image path
     * @param  string  $prefix  The prefix to remove from the URL
     * @return string The public URL
     */
    protected function getImageUrl(string $path, string $prefix = 'storage/photos/'): string
    {
        return str_replace($prefix, '', Storage::url($path));
    }
}
