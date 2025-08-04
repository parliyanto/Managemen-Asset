<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\ChartWidget;

class AssetStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Aset';
    protected static ?int $sort = 1;
    protected static ?string $maxHeight = '300px';
    protected static string $color = 'primary';
    protected int|string|array $columnSpan = '10';


    protected function getData(): array
    {
        $data = Asset::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Aset',
                    'data' => [
                        $data['Aktif'] ?? 0,
                        $data['Rusak'] ?? 0,
                        $data['Tidak Aktif'] ?? 0,
                    ],
                    'backgroundColor' => ['#22c55e', '#f97316', '#ef4444'], // hijau, oranye, merah
                ],
            ],
            'labels' => ['Aktif', 'Rusak', 'Tidak Aktif'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public function getDescription(): ?string
    {
        return 'Distribusi status aset saat ini';
    }

}
