<?php

namespace App\Filament\Resources\PageResource\Widgets;

use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PagesStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = '2px';

    protected function getTablePage(): string
    {
        return ListPages::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Page::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Pages', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
