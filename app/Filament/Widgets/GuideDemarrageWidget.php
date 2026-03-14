<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class GuideDemarrageWidget extends Widget
{
    protected static string $view = 'filament.widgets.guide-demarrage';

    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Guide de démarrage';

    public function getSteps(): array
    {
        $steps = [
            ['title' => 'Utilisateurs', 'description' => 'Gérer les comptes utilisateurs, assigner des rôles et profils.', 'route' => 'filament.admin.resources.users.index'],
            ['title' => 'Produits', 'description' => 'Catalogue des produits : prix, stock, catégories.', 'route' => 'filament.admin.resources.produits.index'],
            ['title' => 'Services', 'description' => 'Offres de services bancaires : tarifs et activation.', 'route' => 'filament.admin.resources.services.index'],
            ['title' => 'Catégories', 'description' => 'Organiser produits et services par catégories.', 'route' => 'filament.admin.resources.categories.index'],
            ['title' => 'Branches', 'description' => 'Grandes sections du catalogue (cartes, comptes, recharges...).', 'route' => 'filament.admin.resources.branches.index'],
            ['title' => 'Commandes', 'description' => 'Produits et services commandés : suivi des achats, états de paiement.', 'route' => 'filament.admin.resources.commandes.index'],
            ['title' => 'Transactions', 'description' => 'Logs des transactions et tentatives de paiement.', 'route' => 'filament.admin.resources.transaction-logs.index'],
            ['title' => 'Services utilisateurs', 'description' => 'Souscriptions aux services : états, suivi et renouvellements.', 'route' => 'filament.admin.resources.service-users.index'],
            ['title' => 'Rôles & Permissions (Shield)', 'description' => 'Module Shield : gérer les rôles et permissions par ressource, page et widget.', 'route' => 'filament.admin.resources.shield.roles.index'],
        ];

        return collect($steps)->map(function ($step) {
            $step['url'] = \Illuminate\Support\Facades\Route::has($step['route'])
                ? route($step['route'])
                : null;
            return $step;
        })->toArray();
    }

    public static function canView(): bool
    {
        return auth()->check();
    }
}
