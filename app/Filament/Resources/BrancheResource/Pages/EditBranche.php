<?php

namespace App\Filament\Resources\BrancheResource\Pages;

use App\Filament\Resources\BrancheResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranche extends EditRecord
{
    protected static string $resource = BrancheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
