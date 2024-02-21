<?php

namespace App\Filament\Resources\Form\SchemaResource\Pages;

use App\Filament\Resources\Form\SchemaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchemas extends ListRecords
{
    protected static string $resource = SchemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
