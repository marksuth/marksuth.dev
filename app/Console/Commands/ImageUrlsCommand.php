<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
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
    protected $description = 'Remove folder prefix from filenames in meta data under img_url';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $meta = $post->meta;

            if (! isset($meta['img_url'])) {
                continue;
            }

            $meta['img_url'] = str_replace(['photos/', 'films/'], '', $meta['img_url']);

            $post->meta = $meta;
            $post->save();
        }
    }
}
