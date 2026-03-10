<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrancheSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['id' => 1, 'name' => 'Agent Bancaire', 'slug' => 'agent-bancaire', 'position' => 1, 'description' => 'Quis occaecati mollitia molestiae repudiandae. Aut odit voluptas corporis. Qui sint ullam atque deserunt alias illo. Ut asperiores dolorem minima.', 'isActive' => 1, 'vignette' => 'branches/01JWA9TPJQP07W9B496V89GPY3.png', 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-05-28 01:59:06'],
            ['id' => 2, 'name' => 'Système solaire', 'slug' => 'systeme-solaire', 'position' => 3, 'description' => 'Energie renouvelable & Photovoltaïque', 'isActive' => 1, 'vignette' => 'branches/01JPAAAR5S364CFM45PQZBJMY5.png', 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-03-22 02:11:57'],
            ['id' => 3, 'name' => 'Energie', 'slug' => 'energie', 'position' => 4, 'description' => 'Et dolorem ipsum pariatur voluptatem qui. Alias aut quia molestiae velit.', 'isActive' => 1, 'vignette' => 'branches/01JPAAEYCPQ03J1NKFC8FDJ11F.jpg', 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-03-22 02:14:56'],
            ['id' => 4, 'name' => 'Technologie', 'slug' => 'technologie', 'position' => 2, 'description' => 'Matériel & service)', 'isActive' => 1, 'vignette' => 'branches/01JPANJGEM7EY47SNXK3M3ZHKQ.png', 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-03-22 02:15:31'],
            ['id' => 5, 'name' => 'Téléphonie ', 'slug' => 'telephonie', 'position' => 5, 'description' => 'Ventes & Réparation Accessoires des téléphones)', 'isActive' => 1, 'vignette' => 'branches/01JPANMVBZDQQ0QMMFEPYNAQGX.jpg', 'created_at' => '2025-01-10 01:44:20', 'updated_at' => '2025-03-22 02:17:14'],
            ['id' => 6, 'name' => 'e-Service', 'slug' => 'e-service', 'position' => 6, 'description' => 'e-Service ', 'isActive' => 1, 'vignette' => 'branches/01JPANV176NX83GRFV15A2STR0.png', 'created_at' => '2025-03-14 14:54:48', 'updated_at' => '2025-03-22 02:17:42'],
            ['id' => 7, 'name' => 'Import & Export ', 'slug' => 'import-export', 'position' => 7, 'description' => 'import et export', 'isActive' => 1, 'vignette' => 'branches/01JPANYYFE5VY7NKPSFFN0HKMD.jpg', 'created_at' => '2025-03-14 14:56:57', 'updated_at' => '2025-03-22 02:18:18'],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->updateOrInsert(['id' => $branch['id']], $branch);
        }
    }
}
