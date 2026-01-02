<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;
use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = PostType::all();
        $collections = PostCollection::all();

        if ($collections->isEmpty()) {
            $collections = PostCollection::factory(3)->create();
        }

        if ($types->isEmpty()) {
            $this->call(PostTypeSeeder::class);
            $types = PostType::all();
        }

        // Create some published posts
        Post::factory(20)->recycle($types)->recycle($collections)->published()->create();

        // Create some drafts
        Post::factory(5)->recycle($types)->recycle($collections)->draft()->create();

        // Create some from distant past
        Post::factory(5)->recycle($types)->recycle($collections)->distantPast()->create();

        // Create some in near future
        Post::factory(5)->recycle($types)->recycle($collections)->nearFuture()->create();
    }
}
