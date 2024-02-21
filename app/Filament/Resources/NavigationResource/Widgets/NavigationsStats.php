<?php

namespace App\Filament\Resources\NavigationResource\Widgets;

use App\Filament\Resources\NavigationResource\Pages\ListNavigations;
use App\Models\Navigation;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NavigationsStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = '2px';

    protected function getTablePage(): string
    {
        return ListNavigations::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Navigation::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Navigations', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
