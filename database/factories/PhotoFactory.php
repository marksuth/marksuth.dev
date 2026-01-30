<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
final class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => $this->faker->paragraph(),
            'meta' => [
                'published' => '1',
                'img_url' => $this->faker->image(null, 640, 480, 'nature', false),
                'location' => $this->faker->city().', '.$this->faker->country(),
                'instagram_url' => 'https://www.instagram.com/p/'.$this->faker->slug(),
            ],
            'published_at' => \Illuminate\Support\Facades\Date::now(),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),
        ];
    }

    /**
     * Indicate that the photo is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta' => array_merge($attributes['meta'] ?? [], ['published' => '1']),
            'published_at' => \Illuminate\Support\Facades\Date::now(),
        ]);
    }

    /**
     * Indicate that the photo is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta' => array_merge($attributes['meta'] ?? [], ['published' => '0']),
            'published_at' => null,
        ]);
    }
}
