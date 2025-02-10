<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Crée 50 produits et les associe à des catégories
       Produit::factory(50)->create()->each(function ($produit) {
        $categories = Category::inRandomOrder()->take(rand(2, 5))->pluck('id');
        $produit->categories()->attach($categories);
    });
    }
}
