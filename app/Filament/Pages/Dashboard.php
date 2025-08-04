<?php

namespace App\Filament\Pages;


use Filament\Pages\Dashboard as BaseDashboard;
// use App\Filament\Widgets\UserListWidget; // ✅ class baru

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
        //    \App\Filament\Widgets\RecentAssetMutations::class,
        ];
    }
    protected function getFooterWidgets(): array
{
    return [
        // UserListWidget::class,
    ];
}
}
