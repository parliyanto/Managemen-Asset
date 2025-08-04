<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AssetOverview extends StatsOverviewWidget
{

    protected int|string|array $columnSpan = '12';


    protected function getCards(): array
    {
        return [
            Card::make('Total Aset', Asset::count())
                ->icon('heroicon-o-archive-box')
                ->color('primary'),

            Card::make('Laptop', Asset::where('kategori', 'Laptop')->count())
                ->icon('heroicon-o-computer-desktop')
                ->color('success'),

            Card::make('Hardware', Asset::where('kategori', 'Hardware')->count())
                ->icon('heroicon-o-cpu-chip')
                ->color('warning'),
        ];
    }
}
