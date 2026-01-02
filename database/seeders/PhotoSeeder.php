<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

final class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some published photos
        Photo::factory(20)->published()->create();

        // Create some drafts
        Photo::factory(5)->draft()->create();
    }
}
