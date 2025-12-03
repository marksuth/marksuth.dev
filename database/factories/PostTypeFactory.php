<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostType>
 */
final class PostTypeFactory extends Factory
{
    protected $model = PostType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'meta' => $this->faker->words(),
        ];
    }
}
