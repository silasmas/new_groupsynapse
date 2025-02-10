<?php

namespace Database\Factories;

use App\Models\Branche;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branche>
 */
class BrancheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Branche::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'isActive' => $this->faker->boolean,
            'vignette' => $this->faker->imageUrl(640, 480, 'business', true, 'Branch'),
        ];
    }
}
