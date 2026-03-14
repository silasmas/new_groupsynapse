<?php

namespace App\Filament\Resources\ConnectionLogResource\Pages;

use App\Filament\Resources\ConnectionLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConnectionLogs extends ListRecords
{
    protected static string $resource = ConnectionLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
