<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

final class FetchMovieInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'films:fetch-movie {url} {--type=23} {--collection=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch film details from a given URL and save to posts table';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $url = $this->argument('url');
        $typeId = (int) $this->option('type');
        $collectionId = (int) $this->option('collection');

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ])->get($url);

            if ($response->failed()) {
                $this->error("Failed to fetch URL. Status: {$response->status()}");

                return self::FAILURE;
            }

            $html = $response->body();
            $crawler = new Crawler($html);

            $title = $crawler->filter('h1.headline-1')->count() ? $crawler->filter('h1.headline-1')->text() : 'N/A';
            $year = $crawler->filter('a[href^="/films/year/"]')->count() ? $crawler->filter('a[href^="/films/year/"]')->first()->text() : 'N/A';
            $director = $crawler->filter('span.directorlist a')->count() ? $crawler->filter('span.directorlist a')->text() : 'N/A';

            if ($director === 'N/A') {
                $director = $crawler->filter('a[href^="/director/"]')->count() ? $crawler->filter('a[href^="/director/"]')->first()->text() : 'N/A';
            }

            $this->info("Title: {$title}");
            $this->info("Year: {$year}");
            $this->info("Director: {$director}");

            $slug = Str::slug($title.'-'.$year);

            $posterUrl = $crawler->filter('meta[property="og:image"]')->count() ? $crawler->filter('meta[property="og:image"]')->attr('content') : null;

            if ($posterUrl) {
                $this->downloadPoster($posterUrl, $slug);
            } else {
                $this->warn('Film poster not found.');
            }

            $post = Post::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => 'REVIEWTEXT',
                    'post_type_id' => 23,
                    'collection_id' => 3,
                    'meta' => [
                        'img_url' => $slug.'.jpg',
                        'director' => $director,
                        'released' => $year,
                        'published' => 1,
                        'letterboxd_url' => $url,
                    ],
                    'published_at' => now(),
                ]
            );

            $this->info("Post saved/updated: {$post->id}");

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");

            return self::FAILURE;
        }
    }

    /**
     * Download and save the film poster.
     */
    protected function downloadPoster(string $url, string $slug): void
    {
        try {
            $response = Http::get($url);

            if ($response->failed()) {
                $this->error("Failed to download poster. Status: {$response->status()}");

                return;
            }

            $path = 'films/'.$slug.'.jpg';

            Storage::disk('public')->put($path, $response->body());

            $this->info("Poster saved to: storage/app/public/{$path}");
        } catch (Exception $e) {
            $this->error("Failed to save poster: {$e->getMessage()}");
        }
    }
}
