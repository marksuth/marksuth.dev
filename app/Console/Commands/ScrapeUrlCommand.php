<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

final class ScrapeUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'films:fetch-movie {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape H1, releasedate, and film poster from a given URL';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $url = $this->argument('url');

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                $this->error("Failed to fetch URL. Status: {$response->status()}");

                return self::FAILURE;
            }

            $html = $response->body();

            $crawler = new Crawler($html);

            $h1 = $crawler->filter('h1')->first()->text('N/A');
            $releaseDate = $crawler->filter('span.releasedate')->first()->text('N/A');

            $this->info("H1: {$h1}");
            $this->info("Release Date: {$releaseDate}");

            $posterImg = $crawler->filter('.film-poster img')->first();

            if ($posterImg->count() > 0) {
                $posterUrl = $posterImg->attr('src');
                if ($posterUrl) {
                    $this->downloadPoster($posterUrl);
                }
            } else {
                $this->warn('Film poster not found.');
            }

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");

            return self::FAILURE;
        }
    }

    /**
     * Download and save the film poster.
     */
    protected function downloadPoster(string $url): void
    {
        try {
            $response = Http::get($url);

            if ($response->failed()) {
                $this->error("Failed to download poster. Status: {$response->status()}");

                return;
            }

            $extension = pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'poster_'.Str::random(10).'.'.$extension;
            $path = 'films/'.$filename;

            Storage::disk('public')->put($path, $response->body());

            $this->info("Poster saved to: storage/app/public/{$path}");
        } catch (Exception $e) {
            $this->error("Failed to save poster: {$e->getMessage()}");
        }
    }
}
