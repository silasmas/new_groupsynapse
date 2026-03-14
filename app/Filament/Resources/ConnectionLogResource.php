<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConnectionLogResource\Pages;
use App\Models\ConnectionLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConnectionLogResource extends Resource
{
    protected static ?string $model = ConnectionLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    protected static ?string $navigationGroup = 'Sécurité';

    protected static ?string $navigationLabel = 'Connexions';

    protected static ?string $modelLabel = 'Connexion';

    protected static ?string $pluralModelLabel = 'Connexions';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('context')
                    ->label('Contexte')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => ($state ?? '') === 'dashboard' ? 'Dashboard' : 'Site')
                    ->color(fn (mixed $state): string => ($state ?? '') === 'dashboard' ? 'info' : 'success'),
                Tables\Columns\TextColumn::make('country')
                    ->label('Pays')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Connexion')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('disconnected_at')
                    ->label('Déconnexion')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durée')
                    ->getStateUsing(fn (ConnectionLog $record): string => $record->getDurationFormatted() ?? '—')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('pages_visited')
                    ->label('Pages visitées')
                    ->formatStateUsing(fn (mixed $state): string => is_array($state) ? count($state) . ' page(s)' : '0')
                    ->tooltip(fn (ConnectionLog $record): ?string => $record->pages_visited ? implode("\n", array_slice($record->pages_visited, -10)) : null),
                Tables\Columns\TextColumn::make('last_activity_at')
                    ->label('Dernière activité')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn (ConnectionLog $record): string => $record->isActive() ? 'success' : 'gray'),
            ])
            ->defaultSort('last_activity_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('context')
                    ->label('Contexte')
                    ->options([
                        'site' => 'Site',
                        'dashboard' => 'Dashboard',
                    ]),
                Tables\Filters\SelectFilter::make('disconnected')
                    ->label('Statut')
                    ->options([
                        'active' => 'Actives',
                        'ended' => 'Terminées',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'active') {
                            $query->whereNull('disconnected_at');
                        } elseif ($data['value'] === 'ended') {
                            $query->whereNotNull('disconnected_at');
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('disconnect')
                    ->label('Déconnecter')
                    ->icon('heroicon-o-arrow-right-on-rectangle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Déconnecter cette session')
                    ->modalDescription('L\'utilisateur sera déconnecté immédiatement. Il devra se reconnecter.')
                    ->visible(fn (ConnectionLog $record): bool => (Auth::user()?->isSuperAdmin() ?? false) && !$record->disconnected_at)
                    ->action(function (ConnectionLog $record): void {
                        $record->update(['disconnected_at' => now()]);
                        $handler = Session::getHandler();
                        $handler->destroy($record->session_id);
                    })
                    ->successNotificationTitle('Session déconnectée'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConnectionLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
