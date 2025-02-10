<?php

namespace Database\Seeders;

use App\Models\Branche;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrancheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Chaque branche aura 10 catégories
      Branche::factory(5)->create()->each(function ($branch) {
        $branch->category()->saveMany(
            \App\Models\Category::factory(10)->make()
        );
    });
    }
}
