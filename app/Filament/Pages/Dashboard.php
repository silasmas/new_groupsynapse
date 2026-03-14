<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ActiveConnectionsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'lg' => 6,
            'xl' => 12,
            '2xl' => 12,
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            ActiveConnectionsWidget::class,
        ];
    }
}
