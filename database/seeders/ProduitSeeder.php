<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        Produit::factory(50)->create()->each(function ($produit) {
            $categories = Category::where('type', 'produit')->inRandomOrder()->take(rand(2, 5))->pluck('id');
            if ($categories->isNotEmpty()) {
                $produit->categories()->attach($categories);
            }
        });
    }
}
