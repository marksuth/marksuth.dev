<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class PostTypeSeeder extends Seeder
{
    public array $postTypes = [
        'Watch',
        'Video',
        'Sign',
        'RSVP',
        'Review',
        'Repost',
        'Reply',
        'Read',
        'Quote',
        'Play',
        'Note',
        'Listen',
        'Like',
        'Lamp',
        'Jam',
        'Item',
        'Issue',
        'Gate',
        'Fence',
        'Exercise',
        'Event',
        'Eat',
        'Drink',
        'Craft',
        'Checkin',
        'Bookmark',
        'Audio',
        'Article',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->postTypes as $postType) {
            PostType::query()->firstOrCreate(
                ['slug' => Str::slug($postType)],
                ['name' => $postType]
            );
        }
    }
}
