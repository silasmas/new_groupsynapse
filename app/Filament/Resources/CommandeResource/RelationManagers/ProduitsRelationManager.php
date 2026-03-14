<?php

namespace App\Filament\Resources\CommandeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProduitsRelationManager extends RelationManager
{
    protected static string $relationship = 'produits';

    protected static ?string $title = 'Produits commandés';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Produit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pivot.quantite')
                    ->label('Quantité')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.prix_unitaire')
                    ->label('Prix unitaire')
                    ->money('CDF'),
                Tables\Columns\TextColumn::make('pivot.prix_total')
                    ->label('Prix total')
                    ->money('CDF'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Produit')
                            ->searchable()
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('quantite')
                            ->label('Quantité')
                            ->numeric()
                            ->required()
                            ->default(1),
                        \Filament\Forms\Components\TextInput::make('prix_unitaire')
                            ->label('Prix unitaire')
                            ->numeric()
                            ->required(),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['prix_total'] = ($data['quantite'] ?? 1) * ($data['prix_unitaire'] ?? 0);
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
