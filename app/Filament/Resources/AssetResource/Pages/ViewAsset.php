<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Placeholder;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    protected function getFormSchema(): array
    {
        return [
            Placeholder::make('qr_code_preview')
                ->label('QR Code')
                ->content(fn ($record) =>
                    $record && $record->qr_code_path
                        ? '<img src="' . asset('storage/' . $record->qr_code_path) . '" width="200">'
                        : 'QR Code belum tersedia.'
                )
                ->html()
                ->columnSpanFull(),
        ];
    }
}
