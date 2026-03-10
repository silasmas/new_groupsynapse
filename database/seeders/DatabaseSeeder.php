<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrancheSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ProduitSeeder::class,
            ServiceSeeder::class,
            NewsletterSeeder::class,
            FavorieSeeder::class,
        ]);
    }
}
