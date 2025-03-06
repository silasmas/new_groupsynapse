<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produit;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProduitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProduitResource\RelationManagers;
use App\Filament\Resources\ProduitResource\Pages\EditProduit;
use App\Filament\Resources\ProduitResource\Pages\ListProduits;
use App\Filament\Resources\ProduitResource\Pages\CreateProduit;

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
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(produit::class, 'slug', ignoreRecord: true)
                            ->columnSpan(6)
                            ->maxLength(255),
                        MarkdownEditor::make('description')
                            ->columnSpan(12)
                            ->maxLength(255),
                        TextInput::make('prix')
                            ->columnSpan(6)
                            ->required()
                            ->numeric(),
                        // TextInput::make('monaie')
                        //     ->maxLength(255),
                        Select::make('monaie')
                            ->options([
                                'FC' => 'Franc congolais',
                                'USD' => 'Dollard',
                                'EURO' => 'Euro',
                            ])
                            ->columnSpan(6)
                            ->default('FC')
                            ->required(),
                        Select::make('categorie_id')
                            ->columnSpan(6)
                            ->required()
                            ->searchable()
                            ->preload()
                            ->multiple()

                            ->relationship('categorie', 'nom'),
                        TextInput::make('qte')
                            ->columnSpan(6)
                            ->maxLength(255),
                        FileUpload::make('images')
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
                        Toggle::make('is_active')
                            ->columnSpan(3)
                            ->default(true)
                            ->required(),
                        Toggle::make('is_featured')
                            ->columnSpan(3)
                            ->default(true)
                            ->required(),
                        Toggle::make('in_stock')
                            ->columnSpan(3)
                            ->default(true)
                            ->required(),
                        Toggle::make('on_sale')
                            ->default(false)
                            ->columnSpan(3)
                            ->required(),
                    ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imageUlrs')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                // TextColumn::make('description')
                //     ->limit(40)
                //     ->searchable(),
                TextColumn::make('prix')
                    ->label('Prix')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->label('Monaie')
                    ->searchable(),
                TextColumn::make('qte')
                    ->label('Quantité')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->label('Favoris')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                IconColumn::make('in_stock')
                    ->label('Disponible')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                IconColumn::make('on_sale')
                    ->label('En vente')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Activé')
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
                ])
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
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? "danger" : "success";
    }    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduits::route('/'),
            'create' => Pages\CreateProduit::route('/create'),
            'edit' => Pages\EditProduit::route('/{record}/edit'),
        ];
    }
}
