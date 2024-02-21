<?php

namespace App\Filament\Resources\Form;

use App\Filament\Resources\Form\CollectionResource\Pages;
use App\Models\Form\Collection;
use App\Models\Form\Schema;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'carbon-table-built';

    protected static ?string $navigationGroup = 'Form';

    protected static bool $shouldRegisterNavigation = true;

    /**
     * @return array<NavigationItem>
     */
    public static function getNavigationItems(): array
    {
        $navigations = [];

        foreach (Schema::query()->orderBy('sort')->get() as $item) {
            $navigations[] = NavigationItem::make($item->name)
                ->label($item->meta['navigation_label'] ?? $item->name)
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName().'.*') && (request()->route()->parameter('schema.id') == $item->id))
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->sort(static::getNavigationSort())
                ->url(static::getUrl('index', [
                    'schema' => $item->id,
                ]));
        }

        return [
            ...$navigations,
        ];
    }

    public static function form(Form $form): Form
    {
        $schemaForms = [];
        $livewire = $form->getLivewire();

        $schema = $livewire?->schema ?? null;

        foreach ($schema?->schema ?: [] as $item) {
            $label = $item['name'];
            $type = $item['type'];
            $key = Str::of($label)->replaceMatches(pattern: '/[^A-Za-z0-9\ ]++/', replace: ' ')->lower()->snake();

            if ($type === 'dropdown:area') {
                $schemaForms[] = Forms\Components\TextInput::make('data.kecamatan')
                    ->label('Kecamatan');

                $schemaForms[] = Forms\Components\TextInput::make('data.kelurahan')
                    ->label('Kelurahan');

            } elseif ($type === 'textarea') {
                $schemaForms[] = Forms\Components\Textarea::make("data.{$key}")
                    ->label($label)
                    ->columnSpan('full');
            } else {
                $schemaForms[] = Forms\Components\TextInput::make("data.{$key}")
                    ->label($label)
                    ->columnSpan('full');
            }

        }

        return $form
            ->schema([
                ...$schemaForms,
            ]);
    }

    public static function table(Table $table): Table
    {
        $columns = [];
        $livewire = $table->getLivewire();
        $schema = $livewire?->schema ?? null;

        foreach ($schema?->schema ?: [] as $item) {
            $label = $item['name'];
            $key = Str::of($label)->replaceMatches(pattern: '/[^A-Za-z0-9\ ]++/', replace: ' ')->lower()->snake();

            if ($item['show-in-table'] ?? false) {
                // handle kecamatan & kelurahan
                if ($item['type'] === 'dropdown:area') {
                    $columns[] = Tables\Columns\TextColumn::make('data.kecamatan')
                        ->label('Kecamatan')
                        ->searchable(query: fn ($query, $search) => $query
                            ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.kecamatan'))) LIKE ?", '%'.strtolower($search).'%')
                        )
                        ->sortable();
                    $columns[] = Tables\Columns\TextColumn::make('data.kelurahan')
                        ->label('Kelurahan')
                        ->searchable(query: fn ($query, $search) => $query
                            ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.kelurahan'))) LIKE ?", '%'.strtolower($search).'%')
                        )
                        ->sortable();
                } else {
                    $columns[] = Tables\Columns\TextColumn::make("data.{$key}")
                        ->label($label)
                        ->searchable(query: fn ($query, $search) => $query
                            ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.{$key}'))) LIKE ?", '%'.strtolower($search).'%')
                        )
                        ->sortable();
                }
            }
        }

        return $table
            ->columns([
                ...$columns,
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->recordUrl(fn ($record) => static::getUrl('view', ['record' => $record, 'schema' => $schema]))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * @param  array<mixed>  $parameters
     */
    public static function getUrl(string $name = 'index', array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

        $parameters['schema'] ??= Route::current()->parameter('schema');

        $routeBaseName = static::getRouteBaseName(panel: $panel);

        return route("{$routeBaseName}.{$name}", $parameters, $isAbsolute);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('{schema}'),
            // 'create' => Pages\CreateCollection::route('/{schema}/create'),
            // 'edit' => Pages\EditCollection::route('/{schema}/{record}/edit'),
            'view' => Pages\ViewCollection::route('{schema}/{record}'),
        ];
    }
}
