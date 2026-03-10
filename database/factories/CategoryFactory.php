<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Category::class;

    public function definition(): array
    {
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['produit', 'service']),
            'vignette' => 'https://via.placeholder.com/640x480.png/00aa66?text=category',
            'isActive' => $this->faker->boolean(80),
        ];
    }
}
