<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
final class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'meta' => [
                'published' => '1',
            ],
            'published_at' => \Illuminate\Support\Facades\Date::now(),
            'created_at' => \Illuminate\Support\Facades\Date::now(),
            'updated_at' => \Illuminate\Support\Facades\Date::now(),

            'post_type_id' => PostType::factory(),
            'collection_id' => PostCollection::factory(),
        ];
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta' => array_merge($attributes['meta'] ?? [], ['published' => '1']),
            'published_at' => \Illuminate\Support\Facades\Date::now(),
        ]);
    }

    /**
     * Indicate that the post is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta' => array_merge($attributes['meta'] ?? [], ['published' => '0']),
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the post is from the distant past.
     */
    public function distantPast(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta' => array_merge($attributes['meta'] ?? [], ['distant_past' => true]),
        ]);
    }

    /**
     * Indicate that the post is in the near future.
     */
    public function nearFuture(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta' => array_merge($attributes['meta'] ?? [], ['near_future' => true]),
            'published_at' => \Illuminate\Support\Facades\Date::now()->addDays(7),
        ]);
    }
}
