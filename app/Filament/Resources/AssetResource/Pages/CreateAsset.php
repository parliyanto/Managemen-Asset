<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\CreateRecord;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    protected function afterCreate(): void
    {
        $asset = $this->record->refresh();

        $fileName = 'asset-' . $asset->id . '.png';
        $relativePath = 'assets/qr/' . $fileName;
        $absolutePath = storage_path('app/public/' . $relativePath);

        if (!file_exists(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data(url('/admin/assets/' . $asset->id)) // ganti ke rute publik jika ada
            ->size(300)
            ->margin(10)
            ->build();

        file_put_contents($absolutePath, $result->getString());

        $asset->qr_code_path = $relativePath;
        $asset->save();
    }
}
