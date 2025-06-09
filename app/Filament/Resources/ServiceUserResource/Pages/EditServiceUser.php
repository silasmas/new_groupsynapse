<?php

namespace App\Filament\Resources\ServiceUserResource\Pages;

use App\Filament\Resources\ServiceUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceUser extends EditRecord
{
    protected static string $resource = ServiceUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
