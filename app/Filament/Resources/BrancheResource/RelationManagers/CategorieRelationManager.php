<?php

namespace App\Filament\Resources\BrancheResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use App\Models\categorie;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CategorieRelationManager extends RelationManager
{
    protected static string $relationship = 'categorie';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulaire')->schema([
                    Select::make('branche_id')
                        ->label(label: 'Catégorie')
                        ->relationship('branche', 'name')
                        ->searchable()
                        ->preload()
                        ->columnSpan(4)
                        ->required(),
                    TextInput::make('nom')
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
                    Toggle::make('is_active')
                        ->columnSpan(4)
                        ->label('Est active')
                        ->required()
                        ->default(0),
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nom')
            ->columns([
                ImageColumn::make('vignette')
                    ->searchable(),
                TextColumn::make('name'),
                TextColumn::make('description')
                ->limit(50)
                ->label('Description'),
                IconColumn::make('is_active')
                ->label('Est active')

                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->form([]) // Désactive le formulaire du modal
                ->url(fn () => route('filament.admin.resources.categories.create')) // Redirige vers la création des branches
                ->openUrlInNewTab(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->form([]) // Désactive le formulaire du modal
                ->url(fn ($record) => route('filament.admin.resources.categories.edit', $record->id)) // Redirige vers l'édition des branches
                ->openUrlInNewTab(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
