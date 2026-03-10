<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsletterSeeder extends Seeder
{
    public function run(): void
    {
        $emails = [
            'silasmas@outlook.fr', 'psaidi@oulook.fr', 'silasjmas@gmail.com', 'diannedwa@gmail.com',
        ];

        foreach ($emails as $email) {
            DB::table('newsletters')->updateOrInsert(
                ['email' => $email],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
