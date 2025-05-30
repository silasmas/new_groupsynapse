<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BrancheResource\Pages;
use App\Filament\Resources\BrancheResource\RelationManagers\CategorieRelationManager;
use App\Models\Branche;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
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

class BrancheResource extends Resource
{
    protected static ?string $model = Branche::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Formulaire')->schema([
                        TextInput::make('name')
                            ->columnSpan(6)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) =>
                                $set('slug', Str::slug($state))
                            )
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(branche::class, 'slug', ignoreRecord: true)
                            ->columnSpan(6)
                            ->maxLength(255),
                        Textarea::make('description')
                            ->columnSpan(12)
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('vignette')
                            ->label('Image :')
                            ->directory('branches')
                            ->columnSpan(12),
                        Toggle::make('isActive')
                            ->required()
                            ->columnSpan(6)
                            ->label('Est active')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                            TextInput::make('position')
                            ->label("La position de la branche sur le menu")
                            ->numeric()
                            ->unique(branche::class, 'position', ignoreRecord: true)
                            ->required()
                            ->columnSpan(6)
                            ->maxLength(255),
                    ])->columnS(12),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('vignette')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                    TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                    TextColumn::make('position')
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
            CategorieRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
             'create' => Pages\CreateBranche::route('/create'),
            'edit'  => Pages\EditBranche::route('/{record}/edit'),
        ];
    }
}
