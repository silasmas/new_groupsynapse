<?php
namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Service;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ServiceResource\Pages;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make('Formulaire')->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->columnSpan(6)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) =>
                                $set('slug', Str::slug($state)))
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(Service::class, 'slug', ignoreRecord: true)
                            ->columnSpan(6)
                            ->maxLength(255),

                        TextInput::make('prix')
                            ->columnSpan(4)
                            ->numeric(),
                        Select::make('currency')
                            ->options([
                                'CDF'  => 'Franc congolais',
                                'USD'  => 'Dollard',
                                'EURO' => 'Euro',
                            ])
                            ->label("Monaie")
                            ->columnSpan(span: 4)
                            ->default('CDF'),
                        Select::make('category_id')           // Plutôt que 'categorie_id'
                            ->relationship('categories', 'name') // Correspond à la relation définie dans le modèle
                            ->columnSpan(4)
                            ->required()
                            ->searchable()
                            ->preload(),
                        FileUpload::make('image')
                            ->columnSpan(6)
                            ->directory('services')
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->downloadable()
                            ->visibility('private')
                            ->image()
                            ->maxSize(3024)
                            ->previewable(true)
                            ->columnSpan(12),
                        MarkdownEditor::make('description')
                            ->label("Description")
                            ->columnSpan(12)
                            ->maxLength(255),
                        Toggle::make('disponible')
                            ->columnSpan(4)
                            ->onColor('success')
                            ->offColor('danger')
                            ->label("Est disponible ?")
                            ->default(false)
                            ->required(),
                        Toggle::make('active')
                            ->columnSpan(4)
                            ->onColor('success')
                            ->offColor('danger')
                            ->label("Est visible ?")
                            ->default(false)
                            ->required(),
                    ])->columnS(12),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 ImageColumn::make('image') // Correspond à la méthode getImageUrlsAttribute()
                    ->label("Images")->size(50),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('categories.name')
                    ->label('Catégorie')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('prix')
                    ->searchable(),
                TextColumn::make('currency')
                    ->searchable(),
                     IconColumn::make('active')
                    ->label('Visible')
                    ->boolean(),
                     IconColumn::make('disponible')
                    ->label('Disponible')
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
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
