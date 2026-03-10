<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['id' => 1, 'name' => 'silas', 'email' => 'silasjmas@gmail.com', 'password' => '$2y$12$711TU4EzfMHAS/C8m6WbnupwkxeyAJcKuMA3nFsIh1hF63sjPmAtm', 'created_at' => '2025-01-10 03:24:59', 'updated_at' => '2025-01-10 03:24:59'],
            ['id' => 2, 'name' => 'Silas masimango', 'email' => 'ir-masimango@silasmas.com', 'password' => '$2y$12$GU0pSRatWOgB6GaPPrjlh.ylZx3/6i0pF2xGNz6amzCFUQUmZo6I2', 'created_at' => '2025-01-29 09:51:00', 'updated_at' => '2025-01-29 09:51:00'],
            ['id' => 3, 'name' => 'Pascal M. SAÏDI', 'email' => 'muninga.saidi@gmail.com', 'password' => '$2y$12$W6tFVzBuWBTvasl0mgDQNuQffTxUmSLBSk4fFEN8.PYpB4RfYW0ii', 'created_at' => '2025-02-18 13:17:54', 'updated_at' => '2025-02-18 13:17:54'],
            ['id' => 4, 'name' => 'ddfd', 'email' => 'contact@silasmas.com', 'email_verified_at' => '2025-07-18 02:50:58', 'password' => '$2y$12$zDcyBvVUx9XRXyjFDq8QC.WEWc8qfyxVOtZ3dtBvX/QoBTADGALjW', 'created_at' => '2025-07-18 02:50:06', 'updated_at' => '2025-07-18 02:50:58'],
            ['id' => 5, 'name' => 'silas', 'email' => 'ikipimo@groupsynapse.org', 'email_verified_at' => '2025-08-16 10:21:04', 'password' => '$2y$12$MYLGa/.yPDvnamJ7/3Qln.6YNP3MWlIkk1KI9jr/fNRjDQfg3EoS2', 'created_at' => '2025-08-16 10:20:20', 'updated_at' => '2025-08-16 10:21:04'],
            ['id' => 6, 'name' => 'Pascal Muninga Saïdi', 'email' => 'psaidi@outlook.fr', 'email_verified_at' => '2025-08-20 14:41:06', 'password' => '$2y$12$2wYm.XqInXCs1aDLmk8s.O1pS30V3ccEqLua/WLFiCL1zJCDD/OKi', 'remember_token' => '69e8JtdALP167humXQze31vJiOhloTVl3KbWXAdYGTl6mcWdBkuIntT9Mcnp', 'created_at' => '2025-08-20 14:40:11', 'updated_at' => '2025-08-20 14:41:06'],
            ['id' => 7, 'name' => 'adminxp', 'email' => 'adminxp@gmail.com', 'password' => '$2y$12$Nt8Id1tu48rfyKcbHBTA0eN4KStv6FIfn3Zq9xu0nRcKIrqatQ1sK', 'created_at' => '2025-09-10 06:17:12', 'updated_at' => '2025-09-10 06:17:12'],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(['id' => $user['id']], $user);
        }

        // Créer un utilisateur de test avec mot de passe connu
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
