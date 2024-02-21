<?php

namespace App\Filament\Pages\Form;

use Filament\Pages\Page;

class Collection extends Page
{
    protected static ?string $navigationIcon = 'carbon-table-built';

    protected static ?string $navigationGroup = 'Form';

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.form.collection';
}
