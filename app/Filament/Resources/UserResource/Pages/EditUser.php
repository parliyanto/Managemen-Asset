<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\ActivityLog;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function afterSave(): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Edit User',
            'description' => 'Mengedit data user: ' . $this->record->name,
        ]);
    }
}
