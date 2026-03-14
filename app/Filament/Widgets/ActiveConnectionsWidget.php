<?php

namespace App\Filament\Widgets;

use App\Models\ConnectionLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActiveConnectionsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $activeCount = ConnectionLog::where('last_activity_at', '>=', now()->subMinutes(config('session.lifetime', 120)))
            ->count();

        $todayCount = ConnectionLog::whereDate('created_at', today())->count();

        return [
            Stat::make('Connexions actives', $activeCount)
                ->description('Sessions en cours')
                ->descriptionIcon('heroicon-m-signal')
                ->color('success'),
            Stat::make('Connexions aujourd\'hui', $todayCount)
                ->description('Depuis minuit')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
