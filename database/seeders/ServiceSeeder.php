<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['id' => 1, 'name' => 'Nouvelle Carte', 'slug' => 'nouvelle-carte', 'form_view' => 'default-form', 'description' => null, 'active' => 1, 'image' => 'services/01K38R6XYTQYS0B399CVQWZSZ8.jpg', 'disponible' => 1, 'prix' => '15', 'currency' => 'USD', 'category_id' => 1, 'created_at' => '2025-05-25 01:30:39', 'updated_at' => '2025-08-22 11:21:50'],
            ['id' => 2, 'name' => 'Renouveler Carte', 'slug' => 'renouveler-carte', 'form_view' => 'default-form', 'description' => null, 'active' => 1, 'image' => 'services/01K38R95M7Q3GRMJ07P8ENSH83.jpg', 'disponible' => 1, 'prix' => null, 'currency' => 'CDF', 'category_id' => 1, 'created_at' => '2025-05-25 01:31:17', 'updated_at' => '2025-08-22 11:23:04'],
            ['id' => 3, 'name' => 'Recharge Carte', 'slug' => 'recharge-carte', 'form_view' => 'default-form', 'description' => null, 'active' => 1, 'image' => 'services/01K38RB4DQFYS3MECBKWV5SQK9.jpg', 'disponible' => 1, 'prix' => null, 'currency' => 'USD', 'category_id' => 1, 'created_at' => '2025-05-25 01:31:43', 'updated_at' => '2025-08-22 11:24:08'],
            ['id' => 4, 'name' => 'Compte Courant', 'slug' => 'compte-courant', 'form_view' => 'default-form', 'description' => null, 'active' => 0, 'image' => 'services/01K38REK45YQJVVVNQ3NYYE4T6.jpg', 'disponible' => 0, 'prix' => null, 'currency' => 'USD', 'category_id' => 2, 'created_at' => '2025-05-25 01:36:17', 'updated_at' => '2025-08-22 11:42:11'],
            ['id' => 5, 'name' => 'Compte Epargne', 'slug' => 'compte-epargne', 'form_view' => 'default-form', 'description' => null, 'active' => 0, 'image' => 'services/01K38RJCSVC6ZGH0V0RM3ZNX91.jpg', 'disponible' => 0, 'prix' => null, 'currency' => 'CDF', 'category_id' => 2, 'created_at' => '2025-05-25 01:36:50', 'updated_at' => '2025-08-22 11:32:01'],
        ];

        foreach ($services as $service) {
            DB::table('services')->updateOrInsert(['id' => $service['id']], $service);
        }
    }
}
