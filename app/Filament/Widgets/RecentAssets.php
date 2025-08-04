<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class RecentAssets extends BaseWidget
{

    protected int|string|array $columnSpan = '12';


    protected function getTableQuery(): Builder|Relation|null
    {
        return Asset::query()->latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->label('Nama Aset'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Tanggal Input'),
        ];
    }
}
