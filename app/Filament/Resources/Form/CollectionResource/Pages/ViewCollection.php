<?php

namespace App\Filament\Resources\Form\CollectionResource\Pages;

use App\Filament\Resources\Form\CollectionResource;
use App\Models\Form\Schema;
use Filament\Resources\Pages\ViewRecord;

class ViewCollection extends ViewRecord
{
    protected static string $resource = CollectionResource::class;

    public ?Schema $schema;
}
