<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    private function generateImageUrls(): array
{
    return [
       'assets/img/product/product1.png',
       'assets/img/product/product2.png',
       'assets/img/product/product3.png',
       'assets/img/product/product4.jpg',
       'assets/img/product/product5.jpg',
    ];
}
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'moreDescription' => $this->faker->text,
            'additionalInfos' => json_encode($this->faker->words(5)), // Exemple : informations additionnelles
            'stock' => $this->faker->numberBetween(0, 100),
            'prix' => (string) $this->faker->randomFloat(2, 10, 500),
            'currency' => $this->faker->randomElement(['USD', 'CDF']),
            'soldePrice' => $this->faker->optional(0.3)->numberBetween(50, 300),
            'imageUrls' =>   json_encode($this->generateImageUrls()),
            // 'imageUrls' => json_encode([
            //     $this->faker->imageUrl(640, 480, 'product', true, 'Product'),
            //     $this->faker->imageUrl(640, 480, 'product', true, 'Product'),
            // ]),
            'brand' => $this->faker->company,
            'isAvalable' => $this->faker->boolean,
            'isBestseler' => $this->faker->boolean,
            'isNewArivale' => $this->faker->boolean,
            'isFeatured' => $this->faker->boolean,
            'isSpecialOffer' => $this->faker->boolean,
        ];
    }
}
