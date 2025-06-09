<?php

namespace App\Filament\Resources\ServiceUserResource\Pages;

use App\Filament\Resources\ServiceUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceUsers extends ListRecords
{
    protected static string $resource = ServiceUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
