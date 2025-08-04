<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;

class EditAsset extends EditRecord
{
    protected static string $resource = AssetResource::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Asset Name')
                ->required(),

            TextArea::make('serial_number')
                ->label('Serial Number')
                ->required(),

            Select::make('kategori')
                ->label('Kategori')
                ->options([
                    'Hardware' => 'Hardware',
                    'Laptop' => 'Laptop',
                    'Aksesoris' => 'Aksesoris',
                ])
                ->required(),

            FileUpload::make('image')
                ->label('Image')
                ->image()
                ->imagePreviewHeight('250')
                ->directory('assets')
                ->required(),

            Placeholder::make('qr_code_preview')
                ->label('QR Code')
                ->content(fn ($record) =>
                $record && $record->qr_code_path
                 ? '<img src="' . asset('storage/' . $record->qr_code_path) . '" width="200">'
                : 'QR Code belum tersedia.'
             )
                ->disableLabel()
                ->columnSpanFull()
                ->reactive()
                ->html(),
        ];
    }
}
