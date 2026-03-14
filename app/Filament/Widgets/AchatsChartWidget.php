<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Widgets\ChartWidget;

class AchatsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Évolution des achats (commandes)';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '300px';

    protected static string $color = 'success';

    protected int | string | array $columnSpan = 6;

    protected function getData(): array
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            $data[] = Commande::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Commandes',
                    'data' => $data,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'fill' => true,
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
        return 'Nombre de commandes par mois sur les 6 derniers mois.';
    }
}
