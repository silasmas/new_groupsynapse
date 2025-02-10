<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Étape 1')
                        ->schema([
                            Section::make('Information générale')->schema([
                                TextInput::make('name')->required()
                                    ->columnSpan(4)
                                    ->label("Nom"),
                                TextInput::make(name: 'prenom')->required()
                                    ->columnSpan(4)
                                    ->label("Prenom"),
                                Select::make('sexe')
                                    ->options([
                                        'H' => 'Homme',
                                        'F' => 'Femme',
                                    ])
                                    ->label("Sexe")
                                    ->searchable()->columnSpan(4),
                                TextInput::make('phone')
                                    ->columnSpan(4)
                                    ->label("Telephone")
                                    ->unique(User::class, 'phone', ignoreRecord: true),
                            ])->columns(12)
                        ]),
                    Step::make('Étape 2')
                        ->schema([
                            Section::make('Role et profil')->schema([
                                FileUpload::make('profil')
                                    ->label('Proto profil')
                                    ->directory('profil')
                                    ->avatar()
                                    ->imageEditor()
                                    ->imageEditorMode(2)
                                    ->circleCropper()
                                    ->downloadable()
                                    ->image()
                                    ->maxSize(3024)
                                    ->columnSpan(4)
                                    ->previewable(true),

                                Select::make('roles')
                                    ->label('Roles')
                                    ->columnSpan(4)
                                    ->preload()
                                    ->multiple() // Permet de sélectionner plusieurs rôles
                                    ->searchable()
                                    ->required()
                                    ->relationship('role', 'name'), // 'roles' est la méthode du modèle User, 'name' est l'attribut à afficher
                                CheckboxList::make('roles')
                                    ->columnSpan(4)
                                    ->relationship('roles', 'name')
                                    ->searchable()
                            ])->columns(12)
                        ]),
                    Step::make('Étape 3')
                        ->schema([
                            Section::make('Identification')
                                ->schema([
                                    TextInput::make('email')->label("Email")
                                        ->email()->maxLength(255)->unique(ignoreRecord: true)
                                        ->required()->columnSpan(6)
                                        ->unique(User::class, 'email', ignoreRecord: true),

                                    TextInput::make('password')->password()->label("Mot de passe")
                                        ->dehydrated(fn($state) => filled($state))
                                        ->required(fn(Page $livewire) => $livewire instanceof CreateRecord)->columnSpan(4),

                                ])->columns(12)
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profil')
                    ->circular()
                    ->defaultImageUrl(url('assets/img/default.jpg'))
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('prenom')
                    ->searchable(),
                TextColumn::make('sexe')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('pays')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('role.name')
                    ->label('Rôle')
                    ->badge()->color('success')
                    ->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
