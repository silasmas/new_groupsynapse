<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommandeResource\Pages;
use App\Filament\Resources\CommandeResource\RelationManagers\ProduitsRelationManager;
use App\Models\Commande;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Ventes';

    protected static ?string $recordTitleAttribute = 'reference';

    protected static ?string $modelLabel = 'Commande';

    protected static ?string $pluralModelLabel = 'Commandes';

    public static function getGloballySearchableAttributes(): array
    {
        return ['reference', 'provider_reference'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations commande')->schema([
                    Forms\Components\TextInput::make('reference')
                        ->label('Référence')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('provider_reference')
                        ->label('Réf. fournisseur')
                        ->maxLength(255),
                    Forms\Components\Select::make('user_id')
                        ->label('Client')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('total')
                        ->label('Total')
                        ->numeric()
                        ->required()
                        ->prefix('CDF'),
                    Forms\Components\TextInput::make('amount_customer')
                        ->label('Montant client')
                        ->numeric()
                        ->prefix('CDF'),
                    Forms\Components\Select::make('currency')
                        ->options(['CDF' => 'CDF', 'USD' => 'USD'])
                        ->default('CDF'),
                    Forms\Components\Select::make('channel')
                        ->label('Canal')
                        ->options(['mobile_money' => 'Mobile Money', 'card' => 'Carte']),
                    Forms\Components\Select::make('etat')
                        ->label('État')
                        ->options([
                            'En attente' => 'En attente',
                            'Payée' => 'Payée',
                            'En cours' => 'En cours',
                            'Livrée' => 'Livrée',
                            'Annulée' => 'Annulée',
                        ])
                        ->default('En attente')
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('livraison')
                        ->label('Livraison'),
                    Forms\Components\TextInput::make('commune')
                        ->label('Commune')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('prix_livraison')
                        ->label('Prix livraison')
                        ->numeric()
                        ->prefix('CDF'),
                    Forms\Components\Textarea::make('description')
                        ->label('Description')
                        ->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('CDF')
                    ->sortable(),
                Tables\Columns\TextColumn::make('etat')
                    ->label('État')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Payée' => 'success',
                        'En attente' => 'warning',
                        'En cours' => 'info',
                        'Livrée' => 'success',
                        'Annulée' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('channel')
                    ->label('Canal')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('etat')
                    ->options([
                        'En attente' => 'En attente',
                        'Payée' => 'Payée',
                        'En cours' => 'En cours',
                        'Livrée' => 'Livrée',
                        'Annulée' => 'Annulée',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ProduitsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommandes::route('/'),
            'create' => Pages\CreateCommande::route('/create'),
            'view' => Pages\ViewCommande::route('/{record}'),
            'edit' => Pages\EditCommande::route('/{record}/edit'),
        ];
    }
}
