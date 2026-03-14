<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Commande;
use App\Models\ServiceUser;
use Filament\Widgets\ChartWidget;

class FonctionnementChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Fonctionnement global';

    protected static ?int $sort = 5;

    protected static ?string $maxHeight = '300px';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = [];
        $users = [];
        $commandes = [];
        $services = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            $users[] = User::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $commandes[] = Commande::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $services[] = ServiceUser::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nouveaux utilisateurs',
                    'data' => $users,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
                [
                    'label' => 'Commandes',
                    'data' => $commandes,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Services souscrits',
                    'data' => $services,
                    'backgroundColor' => 'rgba(249, 115, 22, 0.5)',
                    'borderColor' => 'rgb(249, 115, 22)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): ?string
    {
        return 'Vue d\'ensemble : utilisateurs, commandes et services par mois.';
    }
}
