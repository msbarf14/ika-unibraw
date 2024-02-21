<?php

namespace App\Filament\Resources\Form\CollectionResource\Pages;

use App\Filament\Resources\Form\CollectionResource;
use App\Models\Form\Schema;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

class ListCollections extends ListRecords
{
    protected static string $resource = CollectionResource::class;

    public Schema $schema;

    public function getTabs(): array
    {
        return $tabs = [];

        foreach (Schema::query()->orderBy('sort')->get() as $item) {
            $tabs[$item->name] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('schema_id', $item->id));

        }

        return $tabs;

        return [
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true)),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false)),
        ];
    }

    // public function boot()
    // {
    //     if(!Route::current()->parameter('schema')){
    //         return redirect()->route('filament.admin.resources.form.collections.index', [
    //             'schema' => Schema::first()?->id
    //         ]);
    //     }
    // }

    protected function getTableQuery(): ?Builder
    {
        return static::getResource()::getEloquentQuery()->where('schema_id', $this->schema?->id ?? null);
    }

    public function getTitle(): string|Htmlable
    {
        return parent::getTitle().' '.$this->schema?->name;
    }

    /**
     * @return array<string>
     */
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $breadcrumb = $this->getBreadcrumb();

        return [

            $resource::getUrl('index', [
                'schema' => $this->schema?->id,
            ]) => $resource::getBreadcrumb(),
            ...(filled($breadcrumb) ? [$breadcrumb] : []),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
