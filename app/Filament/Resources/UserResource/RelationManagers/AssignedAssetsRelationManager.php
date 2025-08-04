<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action;

class AssignedAssetsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignedAssets';
    protected static ?string $title = 'Aset yang Dimiliki';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Aset')->sortable()->searchable(),
                TextColumn::make('kategori')->label('Kategori')->sortable(),
                TextColumn::make('status')->label('Status'),
                TextColumn::make('kondisi')->label('Kondisi'),
                ImageColumn::make('image')->label('Gambar')->height(50),
            ])
            ->actions([
                Action::make('Lihat Detail')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('filament.admin.resources.assets.view', ['record' => $record->getKey()]))
                    ->openUrlInNewTab(),
            ])
            ->headerActions([]);
    }
}
