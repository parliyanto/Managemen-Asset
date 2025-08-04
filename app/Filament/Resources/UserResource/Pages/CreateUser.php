<?php 

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ActivityLog;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Create User',
            'description' => 'Menambahkan user: ' . $this->record->name,
        ]);
    }
}
