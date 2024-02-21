<?php

namespace App\Filament\Resources\Form\SchemaResource\Pages;

use App\Filament\Resources\Form\SchemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchema extends EditRecord
{
    protected static string $resource = SchemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
