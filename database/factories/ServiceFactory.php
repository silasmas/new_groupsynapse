<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Service::class;

    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'form_view' => 'default-form',
            'description' => $this->faker->sentence,
            'active' => $this->faker->boolean(70),
            'image' => 'services/' . $this->faker->uuid . '.jpg',
            'disponible' => 1,
            'prix' => (string) $this->faker->randomFloat(2, 5, 100),
            'currency' => $this->faker->randomElement(['USD', 'CDF']),
        ];
    }
}
