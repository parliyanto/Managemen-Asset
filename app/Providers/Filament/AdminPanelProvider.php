<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel; // ini baru di add
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
// use pxlrbt\FilamentExcel\FilamentExcelPlugin;


use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\UserMenuItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandLogo(asset('images/logo.webp'))
            // ->viteTheme('resources/css/filament.css')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                \App\Filament\Widgets\AssetOverview::class,
                \App\Filament\Widgets\RecentAssets::class,
                \App\Filament\Widgets\RecentAssetMutations::class,
                \App\Filament\Widgets\AssetStatusChart::class,
                \App\Filament\Widgets\RecentActivities::class,
            ])
            ->plugins([
                // \pxlrbt\FilamentExcel\FilamentExcelPlugin::make(), // ⬅️ ini yang ditambahkan
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            
            ->userMenuItems(
                auth()->check()
                    ? [
                        UserMenuItem::make()
                            ->label(strtoupper(auth()->user()->role) . ' • ' . auth()->user()->name)
                            ->icon('heroicon-o-user-circle')
                            ->url('#')
                            ->color(auth()->user()->role === 'admin' ? 'danger' : 'success'),

                        UserMenuItem::make()
                            ->label('Logout')
                            ->url('/admin/logout')
                            ->method('POST')
                            ->icon('heroicon-o-arrow-left-on-rectangle')
                            ->color('danger'),
                    ]
                    : []
            )
            ->navigation(function (NavigationBuilder $builder) {
                $user = auth()->user();

                if (!$user) {
                    return $builder;
                }
                

                if ($user->role === 'admin') {
                    return $builder->groups([
                        NavigationGroup::make('Utama')->items([
                            NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->url('/admin'),
                        ]),
                        NavigationGroup::make('Inventory')->items([
                            NavigationItem::make('Asset')
                                ->icon('heroicon-o-rectangle-stack')
                                ->url('/admin/assets'),

                            NavigationItem::make('Mutasi Aset')
                                ->icon('heroicon-o-arrow-path')
                                ->url('/admin/asset-mutations')
                        ]),

                        
                        NavigationGroup::make('Admin')->items([
                            NavigationItem::make('Manajemen Pengguna')
                                ->icon('heroicon-o-users')
                                ->url('/admin/users'),

                            NavigationItem::make('Pengaturan Sistem')
                                ->icon('heroicon-o-cog-8-tooth')
                                ->url('/admin/system-settings'),
                        ]),
                    ]);
                }


                // untuk memunculkan daftar menu yang berbeda contoh di sini saya hanya akan menampilkan menu asset saja 
                // tambahkan menu lain sesuai kebutuhan
                return $builder->groups([
                    NavigationGroup::make('Inventaris')->items([
                        NavigationItem::make('Aset Saya')
                            ->icon('heroicon-o-rectangle-stack')
                            ->url('/admin/assets'),
                    ]),
                ]);
            });
    }
}
