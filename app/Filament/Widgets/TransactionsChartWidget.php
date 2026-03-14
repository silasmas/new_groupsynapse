<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Widgets\ChartWidget;

class TransactionsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Transactions (paiements)';

    protected static ?int $sort = 4;

    protected static ?string $maxHeight = '300px';

    protected static string $color = 'primary';

    protected int | string | array $columnSpan = 6;

    protected function getData(): array
    {
        $months = [];
        $payees = [];
        $enAttente = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            $payees[] = Commande::where('etat', 'Payée')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $enAttente[] = Commande::where('etat', 'En attente')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Payées',
                    'data' => $payees,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'En attente',
                    'data' => $enAttente,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.5)',
                    'borderColor' => 'rgb(251, 191, 36)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getDescription(): ?string
    {
        return 'Commandes payées vs en attente par mois.';
    }
}
