<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class DownloadFilmImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'films:save-posters {--dry-run : Run without downloading files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads external img_url for films in collection id 3';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $posts = Post::where('collection_id', 3)->get();

        if ($posts->isEmpty()) {
            $this->info('No posts found for collection id 3.');

            return;
        }

        $this->info("Found {$posts->count()} posts.");

        $bar = $this->output->createProgressBar($posts->count());

        foreach ($posts as $post) {
            $meta = $post->meta;
            $imgUrl = $meta['img_url'] ?? null;

            if ($imgUrl && Str::startsWith($imgUrl, 'http')) {
                if ($this->option('dry-run')) {
                    $this->info("\nDry run: Would download {$imgUrl} for post #{$post->id}");
                    $bar->advance();

                    continue;
                }

                try {
                    $response = Http::get($imgUrl);

                    if ($response->successful()) {
                        $extension = pathinfo(parse_url($imgUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                        $filename = $post->slug.'.'.$extension;
                        $path = 'films/'.$filename;

                        Storage::disk('public')->put($path, $response->body());

                        $meta['img_url'] = $path;
                        $post->meta = $meta;
                        $post->save();
                    } else {
                        $this->error("\nFailed to download image for post #{$post->id}: {$imgUrl}");
                    }
                } catch (Exception $e) {
                    $this->error("\nError downloading image for post #{$post->id}: {$e->getMessage()}");
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Done.');
    }
}
