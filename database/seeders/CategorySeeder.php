<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Carte Bancaire', 'slug' => 'reiciendis-recusandae-hic-iusto-ullam-dolorem-quia-et-alias', 'description' => 'Et suscipit voluptate assumenda debitis voluptas.', 'type' => 'service', 'vignette' => 'https://via.placeholder.com/640x480.png/00aa66?text=category', 'isActive' => 1, 'branche_id' => 1, 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-01-10 01:44:20'],
            ['id' => 2, 'name' => 'Compte Bancaire', 'slug' => 'sunt-nam-aperiam-harum-dolorum-tempore', 'description' => 'Suscipit alias tempore soluta.', 'type' => 'service', 'vignette' => 'https://via.placeholder.com/640x480.png/0011bb?text=category', 'isActive' => 1, 'branche_id' => 1, 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-01-10 01:44:20'],
            ['id' => 3, 'name' => 'Compte XPresse', 'slug' => 'a-quod-nihil-aliquam', 'description' => 'Qui quia officia molestiae placeat quisquam.', 'type' => 'service', 'vignette' => 'https://via.placeholder.com/640x480.png/00ccdd?text=category', 'isActive' => 1, 'branche_id' => 1, 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-01-10 01:44:20'],
            ['id' => 4, 'name' => 'Transaction financière', 'slug' => 'consectetur-explicabo-alias-maiores-et-dolorem-quaerat', 'description' => 'Aspernatur ex iure aliquid minus ipsa.', 'type' => 'service', 'vignette' => 'https://via.placeholder.com/640x480.png/001166?text=category', 'isActive' => 1, 'branche_id' => 1, 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-01-10 01:44:20'],
        ];

        foreach (range(5, 50) as $i) {
            $categories[] = [
                'id' => $i,
                'name' => 'Catégorie ' . $i,
                'slug' => 'categorie-' . $i . '-slug-' . $i,
                'description' => 'Description catégorie ' . $i,
                'type' => 'produit',
                'vignette' => 'https://via.placeholder.com/640x480.png/00' . str_pad(dechex($i * 5), 2, '0') . '66?text=cat',
                'isActive' => $i % 5 !== 0 ? 1 : 0,
                'branche_id' => (($i - 1) % 7) + 1,
                'created_at' => '2025-01-10 01:44:20',
                'updated_at' => '2025-01-10 01:44:20',
            ];
        }

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(['id' => $cat['id']], $cat);
        }
    }
}
