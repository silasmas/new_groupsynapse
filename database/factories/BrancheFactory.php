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
        $name = $this->faker->company;
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'position' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->paragraph,
            'isActive' => $this->faker->boolean(80),
            'vignette' => 'branches/' . $this->faker->uuid . '.png',
        ];
    }
}
