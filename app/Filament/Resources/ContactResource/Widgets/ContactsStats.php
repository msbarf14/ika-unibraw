<?php

namespace App\Filament\Resources\ContactResource\Widgets;

use App\Filament\Resources\ContactResource\Pages\ManageContacts;
use App\Models\Contact;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ContactsStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = '2px';

    protected function getTablePage(): string
    {
        return ManageContacts::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Contact::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Contacts', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
