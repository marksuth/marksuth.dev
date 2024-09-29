<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostTypeSeeder extends Seeder
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
    public function run($postTypes): void
    {
        foreach ($postTypes as $postType) {
            PostType::create([
                'name' => $postType,
                'slug' => Str::slug($postType),
            ]);
        }
    }
}
