<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use App\Models\ActivityLog;
use Filament\Actions\CreateAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => auth()->user()?->role === 'admin'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
                ->after(function ($record) {
                    ActivityLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'Delete User',
                        'description' => 'Menghapus user: ' . $record->name,
                    ]);
                }),
        ];
    }
}
