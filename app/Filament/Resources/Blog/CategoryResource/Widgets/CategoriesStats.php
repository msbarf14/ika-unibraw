<?php

namespace App\Filament\Resources\Blog\CategoryResource\Widgets;

use App\Filament\Resources\Blog\CategoryResource\Pages\ManageCategories;
use App\Models\Blog\Category;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CategoriesStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = '2px';

    protected function getTablePage(): string
    {
        return ManageCategories::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Category::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Categories', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
