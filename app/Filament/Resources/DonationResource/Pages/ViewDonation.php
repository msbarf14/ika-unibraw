<?php

namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDonation extends ViewRecord
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Campaign')
        ];
    }
}
