<?php 

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class RecentActivities extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Terakhir';
    protected int|string|array $columnSpan = 6;

    protected function getTableQuery(): Builder
    {
        return ActivityLog::with('user')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')->label('Waktu')->dateTime('d M Y H:i'),
            TextColumn::make('user.name')->label('User')->sortable(),
            TextColumn::make('action')->label('Aksi'),
            TextColumn::make('description')->label('Deskripsi')->wrap(),
        ];
    }
}
