<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\AssignedAssetsRelationManager;
use App\Models\User;
use App\Models\ActivityLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Manajemen Pengguna';
    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255)
                    ->label('Password'),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->required()
                    ->default('user'),
                // ✅ Tambahkan ini
                Forms\Components\FileUpload::make('profile_photo')
                    ->label('Foto Profil')
                    ->image()
                    ->imagePreviewHeight(100)
                    ->directory('users/photos')
                    ->disk('public')
                    ->enableDownload()
                    ->enableOpen()
                    ->maxSize(1024),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                ->label('Foto')
                ->disk('public')
                ->circular()
                ->height(40),
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'admin' => 'danger',
                        'user' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('assigned_assets_count')
                    ->label('Total Asset')
                    ->sortable()
                    ->alignCenter()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        // Catat aktivitas setelah menghapus user
                        ActivityLog::create([
                            'user_id' => auth()->id(),
                            'action' => 'Delete User',
                            'description' => 'Menghapus user: ' . $record->name,
                        ]);
                    }),
                Tables\Actions\Action::make('Reset Password')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->form([
                        TextInput::make('new_password')
                            ->label('Password Baru')
                            ->password()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->visible(fn () => auth()->user()->role === 'admin')
                    ->action(function ($record, array $data) {
                        $record->update([
                            'password' => bcrypt($data['new_password']),
                        ]);

                        // ✅ Catat aktivitas
                        ActivityLog::create([
                            'user_id' => auth()->id(),
                            'action' => 'Reset Password',
                            'description' => 'Mereset password untuk user: ' . $record->name,
                        ]);

                        Notification::make()
                            ->title('Password berhasil direset')
                            ->body('Password untuk pengguna ' . $record->name . ' telah direset.')
                            ->success()
                            ->send();
                    }),
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
            AssignedAssetsRelationManager::class,
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('assignedAssets');
    }

    public static function canCreate(): bool
    {
    return auth()->user()?->role === 'admin';
    }

}
