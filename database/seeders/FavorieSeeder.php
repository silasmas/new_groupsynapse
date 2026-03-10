<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavorieSeeder extends Seeder
{
    public function run(): void
    {
        $favories = [
            ['user_id' => 1, 'produit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'produit_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'produit_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($favories as $f) {
            DB::table('favories')->updateOrInsert(
                ['user_id' => $f['user_id'], 'produit_id' => $f['produit_id']],
                $f
            );
        }
    }
}
