<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\categorie;
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
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CategorieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategorieResource\RelationManagers;
use App\Filament\Resources\CategorieResource\Pages\EditCategorie;
use App\Filament\Resources\CategorieResource\Pages\ListCategories;
use App\Filament\Resources\CategorieResource\Pages\CreateCategorie;
use App\Models\Category;

class CategorieResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Formulaire')->schema([
                        Select::make('branche_id')
                            ->label(label: 'Catégorie')
                            ->relationship('branches', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(4)
                            ->required(),
                        TextInput::make('name')
                            ->live(onBlur: true)
                            ->columnSpan(4)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) =>
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(Category::class, 'slug', ignoreRecord: true)
                            ->columnSpan(4)
                            ->maxLength(255),
                        Textarea::make('description')
                            ->columnSpan(12)
                            ->maxLength(255),
                        FileUpload::make('vignette')
                            ->label('Image :')
                            ->directory('categories')
                            ->columnSpan(12),
                        Toggle::make('isActive')
                            ->columnSpan(4)
                            ->label('Est active')
                            ->required()
                            ->default(0),
                    ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('vignette')
                    ->searchable(),
                TextColumn::make('branches.name')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                IconColumn::make('isActive')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            // 'create' => Pages\CreateCategorie::route('/create'),
            // 'edit' => Pages\EditCategorie::route('/{record}/edit'),
        ];
    }
}
