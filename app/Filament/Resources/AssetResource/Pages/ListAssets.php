<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions;
use Filament\Actions\CreateAction; // ✅ ini yang benar!

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getTableActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Actions\DeleteBulkAction::make(),
        ];
    }

    // ✅ Ini akan menampilkan tombol "New Asset"
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
