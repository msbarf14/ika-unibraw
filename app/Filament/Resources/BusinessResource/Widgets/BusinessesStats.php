<?php

namespace App\Filament\Resources\BusinessResource\Widgets;

use App\Filament\Resources\BusinessResource\Pages\ListBusinesses;
use App\Models\Business;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BusinessesStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = '2px';

    protected function getTablePage(): string
    {
        return ListBusinesses::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Business::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Businesses', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
