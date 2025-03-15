<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProduitResource\Pages;
use App\Models\Produit;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProduitResource extends Resource
{
    protected static ?string $model = Produit::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Formulaire')->schema([
                        TextInput::make('name')
                            ->live(onBlur: true)
                            ->columnSpan(6)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) =>
                                $set('slug', Str::slug($state)))
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(produit::class, 'slug', ignoreRecord: true)
                            ->columnSpan(6)
                            ->maxLength(255),
                        MarkdownEditor::make('description')
                            ->label("Description")
                            ->columnSpan(12)
                            ->maxLength(255),
                        MarkdownEditor::make('moreDescription')
                            ->label("Plus d'information")
                            ->columnSpan(6)
                            ->maxLength(255),
                        MarkdownEditor::make('additionalInfos')
                            ->label("Informations supplémentaires")
                            ->columnSpan(6)
                            ->maxLength(255),
                        TextInput::make('prix')
                            ->columnSpan(6)
                            ->required()
                            ->numeric(),
                        Select::make('currency')
                            ->options([
                                'CDF'  => 'Franc congolais',
                                'USD'  => 'Dollard',
                                'EURO' => 'Euro',
                            ])
                            ->label("Monaie")
                            ->columnSpan(span: 6)
                            ->default('CDF')
                            ->required(),
                        Select::make('categories')           // Plutôt que 'categorie_id'
                            ->relationship('categories', 'name') // Correspond à la relation définie dans le modèle
                            ->columnSpan(6)
                            ->required()
                            ->searchable()
                            ->preload()
                            ->multiple(),
                        TextInput::make('stock')
                            ->columnSpan(6)
                            ->maxLength(255),
                        FileUpload::make('imageUrls')
                            ->label('Photo des image (Vous pouveez de selectioner plusieurs) :')
                            ->directory('produits')
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->downloadable()
                            ->visibility('private')
                            ->image()
                            ->multiple()
                            ->maxSize(3024)
                            ->previewable(true)
                            ->columnSpan(12),
                        Toggle::make('isAvalable')
                            ->columnSpan(3)
                            ->onColor('success')
                            ->offColor('danger')
                            ->label("Disponible")
                            ->default(true)
                            ->required(),
                        Toggle::make('isFeatured')
                            ->columnSpan(3)
                            ->onColor('success')
                            ->offColor('danger')
                            ->label("En vedette")
                            ->default(true)
                            ->required(),
                        Toggle::make('isBestseler')
                            ->columnSpan(3)
                            ->onColor('success')
                            ->offColor('danger')
                            ->label("Meilleure Vente")
                            ->default(true)
                            ->required(),
                        Toggle::make('isNewArivale')
                            ->columnSpan(3)
                            ->onColor('success')
                            ->offColor('danger')
                            ->label("Nouvelle Arrivée")
                            ->default(true)
                            ->required(),
                    ])->columnS(12),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imageUrls') // Correspond à la méthode getImageUrlsAttribute()
                    ->label("Images")
                    ->getStateUsing(fn ($record) => $record->imageUrls)->stacked() // Affiche plusieurs images sous forme de pile
                    ->size(50), // Ajuste la taille des images

                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('categories.name')
                    ->label('Catégories')
                    ->badge() // Affiche les catégories sous forme de badge
                    ->sortable()
                    ->searchable(),
                TextColumn::make('prix')
                    ->label('Prix')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->label('Monaie')
                    ->searchable(),
                TextColumn::make('stock')
                    ->label('Quantité')
                    ->searchable(),
                IconColumn::make('isFeatured')
                    ->label('Favoris')
                    ->boolean(),
                IconColumn::make('isAvalable')
                    ->label('Disponible')
                    ->boolean(),
                IconColumn::make('isBestseler')
                    ->label('Meilleur vente')
                    ->boolean(),
                IconColumn::make('isNewArivale')
                    ->label('Nouvelle arrivage')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): string | array | null
    {
        return static::getModel()::count() > 10 ? "danger" : "success";
    }public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProduits::route('/'),
            'create' => Pages\CreateProduit::route('/create'),
            'edit'   => Pages\EditProduit::route('/{record}/edit'),
        ];
    }
}
