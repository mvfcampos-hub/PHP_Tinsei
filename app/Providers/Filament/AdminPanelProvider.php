<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\LatestMessages;
use App\Filament\Widgets\SiteOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Tinsei · Painel')
            ->brandLogo(asset('images/brand/logo-tinsei-color.png'))
            ->darkModeBrandLogo(asset('images/brand/logo-tinsei-white.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('favicon.png'))
            ->login()
            ->colors([
                'primary' => Color::hex('#0B5A85'),
                'warning' => Color::hex('#E8B042'),
                'success' => Color::hex('#3C7A20'),
            ])
            ->font('Inter')
            ->navigationGroups([
                NavigationGroup::make('Conteúdo'),
                NavigationGroup::make('Institucional'),
                NavigationGroup::make('Comercial'),
                NavigationGroup::make('Configurações')->collapsed(),
            ])
            ->navigationItems([
                NavigationItem::make('Ver site')
                    ->url(fn () => url('/'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-globe-alt')
                    ->sort(99),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                SiteOverview::class,
                LatestMessages::class,
            ])
            ->sidebarCollapsibleOnDesktop()
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
            ]);
    }
}
