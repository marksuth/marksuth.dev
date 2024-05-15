<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\PostType;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        foreach($postTypes as $postType) {
            PostType::create(['name' => 'Watch', 'slug' => 'watch']);
            PostType::create(['name' => 'Video', 'slug' => 'video']);
            PostType::create(['name' => 'Sign', 'slug' => 'sign']);
            PostType::create(['name' => 'RSVP', 'slug' => 'rsvp']);
            PostType::create(['name' => 'Review', 'slug' => 'review']);
            PostType::create(['name' => 'Repost', 'slug' => 'repost']);
            PostType::create(['name' => 'Reply', 'slug' => 'reply']);
            PostType::create(['name' => 'Read', 'slug' => 'read']);
            PostType::create(['name' => 'Quote', 'slug' => 'quote']);
            PostType::create(['name' => 'Play', 'slug' => 'play']);
            PostType::create(['name' => 'Note', 'slug' => 'note']);
            PostType::create(['name' => 'Listen', 'slug' => 'listen']);
            PostType::create(['name' => 'Like', 'slug' => 'like']);
            PostType::create(['name' => 'Lamp', 'slug' => 'lamp']);
            PostType::create(['name' => 'Jam', 'slug' => 'jam']);
            PostType::create(['name' => 'Item', 'slug' => 'item']);
            PostType::create(['name' => 'Issue', 'slug' => 'issue']);
            PostType::create(['name' => 'Gate', 'slug' => 'gate']);
            PostType::create(['name' => 'Fence', 'slug' => 'fence']);
            PostType::create(['name' => 'Exercise', 'slug' => 'exercise']);
            PostType::create(['name' => 'Event', 'slug' => 'event']);
            PostType::create(['name' => 'Eat', 'slug' => 'eat']);
            PostType::create(['name' => 'Drink', 'slug' => 'drink']);
            PostType::create(['name' => 'Craft', 'slug' => 'craft']);
            PostType::create(['name' => 'Checkin', 'slug' => 'checkin']);
            PostType::create(['name' => 'Bookmark', 'slug' => 'bookmark']);
            PostType::create(['name' => 'Audio', 'slug' => 'audio']);
            PostType::create(['name' => 'Article', 'slug' => 'article']);
        }
    }
}
