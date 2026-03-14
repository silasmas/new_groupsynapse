<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make('Informations personnelles')
                            ->schema([
                                $this->getNameFormComponent(),
                                TextInput::make('prenom')
                                    ->label('Prénom')
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                FileUpload::make('profil')
                                    ->label('Photo de profil')
                                    ->directory('profil')
                                    ->avatar()
                                    ->imageEditor()
                                    ->imageEditorMode(2)
                                    ->circleCropper()
                                    ->image()
                                    ->maxSize(3024)
                                    ->columnSpanFull(),
                                CheckboxList::make('roles')
                                    ->label('Rôles')
                                    ->relationship('roles', 'name')
                                    ->searchable()
                                    ->columnSpanFull()
                                    ->visible(fn () => $this->getUser()->isSuperAdmin()),
                            ])
                            ->columns(2),
                        Section::make('Sécurité')
                            ->schema([
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                            ])
                            ->columns(2),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(false),
            ),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->getUser();
        $data['roles'] = $user->roles->pluck('id')->toArray();
        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $roles = $data['roles'] ?? null;
        unset($data['roles']);

        $record->update($data);

        if ($roles !== null) {
            $record->syncRoles($roles);
        }

        return $record;
    }

}
