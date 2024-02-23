<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Login;
use App\Filament\Pages\Profile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\View\Components\Modal;
use Filament\Tables\Table;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Modal::closedByClickingAway(false);
        Table::configureUsing(function (Table $table): void {
            $table->defaultPaginationPageOption(25)
                ->paginationPageOptions([10, 25, 50, 100]);
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->url(fn () => Profile::getUrl()),
            ])
            ->path('/sitemanager')
            ->login(Login::class)
            ->navigationItems([
                NavigationItem::make('to-web')
                    ->label('Visit Website')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn () => '/', shouldOpenInNewTab: true)
                    ->sort(-2),
            ])
            ->navigationGroups([
                NavigationGroup::make('Form'),
                NavigationGroup::make('Blog'),
                NavigationGroup::make('Guest Books'),
                NavigationGroup::make('Pengaturan'),
            ])
            ->spa()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->sidebarWidth('16rem')
            ->font('DM Sans')
            ->favicon(asset('favicon.png'))
            ->brandLogo(new HtmlString(Blade::render(<<<'HTML'
                <x-shared.logo class="h-full" />
            HTML)))
            ->brandLogoHeight('2rem')
            ->renderHook('panels::styles.before', fn (): string => Blade::render(<<<'HTML'
                <style>
                    /** Setting Base Font */
                    html, body{
                        font-size: 13px;
                    }
                </style>
            HTML))
            ->renderHook('panels::resource.pages.list-records.table.after', fn (): string => Blade::render(<<<'HTML'
                <x-modal-loading wire:loading wire:target="gotoPage,nextPage,previousPage,mountTableAction" />
            HTML))
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                Profile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
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
