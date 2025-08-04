<?php

namespace App\Filament\Components;

use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\Navigation\UserMenuItem;

class CustomUserMenu
{
    public static function getItems(Panel $panel): array
    {
        $user = auth()->user();

        return [
            UserMenuItem::make()
                ->label(ucfirst($user->role) . ' • ' . $user->name)
                ->icon('heroicon-o-user-circle')
                ->url('#'),

            ...$panel->getDefaultUserMenuItems(),
        ];
    }
}
