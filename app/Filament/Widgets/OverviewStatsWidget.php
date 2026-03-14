<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Produit;
use App\Models\Service;
use App\Models\Category;
use App\Models\Branche;
use App\Models\ServiceUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OverviewStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $stats = [];

        // Utilisateurs
        $totalUsers = User::count();
        $usersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $stats[] = Stat::make('Utilisateurs', $totalUsers)
            ->description($usersThisMonth . ' ce mois')
            ->descriptionIcon('heroicon-m-users')
            ->color('primary')
            ->url(route('filament.admin.resources.users.index'));

        // Produits
        $totalProduits = Produit::count();
        $disponibles = Produit::where('isAvalable', true)->count();
        $stats[] = Stat::make('Produits', $totalProduits)
            ->description($disponibles . ' disponibles')
            ->descriptionIcon('heroicon-m-squares-2x2')
            ->color('success')
            ->url(route('filament.admin.resources.produits.index'));

        // Services
        $totalServices = Service::count();
        $actifsServices = Service::where('active', true)->where('disponible', true)->count();
        $stats[] = Stat::make('Services', $totalServices)
            ->description($actifsServices . ' actifs')
            ->descriptionIcon('heroicon-m-rectangle-stack')
            ->color('info')
            ->url(route('filament.admin.resources.services.index'));

        // Catégories
        $totalCategories = Category::count();
        $activesCategories = Category::where('isActive', true)->count();
        $stats[] = Stat::make('Catégories', $totalCategories)
            ->description($activesCategories . ' actives')
            ->descriptionIcon('heroicon-m-tag')
            ->color('warning')
            ->url(route('filament.admin.resources.categories.index'));

        // Branches
        $totalBranches = Branche::count();
        $activesBranches = Branche::where('isActive', true)->count();
        $stats[] = Stat::make('Branches', $totalBranches)
            ->description($activesBranches . ' actives')
            ->descriptionIcon('heroicon-m-rectangle-stack')
            ->color('gray')
            ->url(route('filament.admin.resources.branches.index'));

        // Services utilisateurs
        $totalServiceUsers = ServiceUser::count();
        $enCours = ServiceUser::where('etat', 'en cours')->count();
        $stats[] = Stat::make('Services utilisateurs', $totalServiceUsers)
            ->description($enCours . ' en cours')
            ->descriptionIcon('heroicon-m-user-plus')
            ->color('danger')
            ->url(route('filament.admin.resources.service-users.index'));

        // Rôles (Spatie/Shield)
        if (Schema::hasTable('roles')) {
            try {
                $totalRoles = DB::table('roles')->count();
                $stats[] = Stat::make('Rôles', $totalRoles)
                    ->description('Permissions Shield')
                    ->descriptionIcon('heroicon-m-shield-check')
                    ->color('primary')
                    ->url(route('filament.admin.resources.shield.roles.index'));
            } catch (\Throwable $e) {
                // Ignorer si erreur
            }
        }

        return $stats;
    }
}
