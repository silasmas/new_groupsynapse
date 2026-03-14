<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use App\Models\ServiceUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Route;

class ActiviteStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Activité et ventes';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $stats = [];

        $serviceUsersUrl = Route::has('filament.admin.resources.service-users.index')
            ? route('filament.admin.resources.service-users.index')
            : null;

        // Achats produits (commandes)
        $achatsProduits = Commande::count();
        $achatsPayees = Commande::where('etat', 'Payée')->count();
        $stats[] = Stat::make('Achats produits', $achatsProduits)
            ->description($achatsPayees . ' payées')
            ->descriptionIcon('heroicon-m-shopping-cart')
            ->color('success');

        // Nouvelle carte (achat)
        $nouvelleCarte = ServiceUser::whereHas('service', fn ($q) => $q->where('slug', 'nouvelle-carte'))->count();
        $stat = Stat::make('Nouvelles cartes', $nouvelleCarte)
            ->description('Demandes')
            ->descriptionIcon('heroicon-m-credit-card')
            ->color('primary');
        if ($serviceUsersUrl) {
            $stat->url($serviceUsersUrl);
        }
        $stats[] = $stat;

        // Renouvellement carte
        $renouvellement = ServiceUser::whereHas('service', fn ($q) => $q->where('slug', 'renouveler-carte'))->count();
        $stat = Stat::make('Renouvellements', $renouvellement)
            ->description('Cartes')
            ->descriptionIcon('heroicon-m-arrow-path')
            ->color('info');
        if ($serviceUsersUrl) {
            $stat->url($serviceUsersUrl);
        }
        $stats[] = $stat;

        // Recharge carte
        $recharge = ServiceUser::whereHas('service', fn ($q) => $q->where('slug', 'recharge-carte'))->count();
        $stat = Stat::make('Recharges carte', $recharge)
            ->description('Demandes')
            ->descriptionIcon('heroicon-m-bolt')
            ->color('warning');
        if ($serviceUsersUrl) {
            $stat->url($serviceUsersUrl);
        }
        $stats[] = $stat;

        // Services agence bancaire (compte courant, compte épargne)
        $agenceBancaire = ServiceUser::whereHas('service', fn ($q) => $q->whereIn('slug', ['compte-courant', 'compte-epargne']))->count();
        $stat = Stat::make('Agence bancaire', $agenceBancaire)
            ->description('Comptes courant/épargne')
            ->descriptionIcon('heroicon-m-building-office')
            ->color('gray');
        if ($serviceUsersUrl) {
            $stat->url($serviceUsersUrl);
        }
        $stats[] = $stat;

        // Autres services (futurs services : XPresse, transactions, etc.)
        $autresServices = ServiceUser::whereHas('service', fn ($q) => $q->whereNotIn('slug', ['nouvelle-carte', 'renouveler-carte', 'recharge-carte', 'compte-courant', 'compte-epargne']))->count();
        $stat = Stat::make('Autres services', $autresServices)
            ->description('XPresse, transactions…')
            ->descriptionIcon('heroicon-m-ellipsis-horizontal')
            ->color('danger');
        if ($serviceUsersUrl) {
            $stat->url($serviceUsersUrl);
        }
        $stats[] = $stat;

        return $stats;
    }
}
