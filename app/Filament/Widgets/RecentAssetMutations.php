<?php

namespace App\Filament\Widgets;

use App\Models\AssetMutation;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class RecentAssetMutations extends BaseWidget
{
    protected int|string|array $columnSpan = '2';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                AssetMutation::with(['asset', 'fromUser', 'toUser'])->latest()
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('asset.name')
                    ->label('Aset')
                    ->sortable(),

                TextColumn::make('fromUser.name')
                    ->label('Dari')
                    ->default('-'),

                TextColumn::make('toUser.name')
                    ->label('Ke'),

                TextColumn::make('notes')
                    ->label('Catatan')
                    ->wrap(),
            ]);
    }
}
