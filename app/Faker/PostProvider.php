<?php

declare(strict_types=1);

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Str;

final class PostProvider extends Base
{
    /**
     * Generate a random post title.
     */
    public function postTitle(): string
    {
        return $this->generator->sentence(rand(3, 6));
    }

    /**
     * Generate a random post content.
     */
    public function postContent(): string
    {
        return $this->generator->paragraphs(rand(3, 10), true);
    }

    /**
     * Generate a full post data array.
     *
     * @return array<string, mixed>
     */
    public function post(): array
    {
        $title = $this->postTitle();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->postContent(),
            'published_at' => now()->subMinutes(rand(0, 10000))->format('Y-m-d H:i:s'),
            'meta' => [
                'published' => '1',
            ],
        ];
    }
}
