<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationResource\Pages;
use App\Filament\Resources\NavigationResource\Widgets\NavigationsStats;
use App\Models\Form\Schema;
use App\Models\Navigation;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NavigationResource extends Resource
{
    protected static ?string $model = Navigation::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'carbon-tree-view-alt';

    public static function form(Form $form): Form
    {
        $formSchema = [
            Forms\Components\TextInput::make('name')
                ->required(),

            Forms\Components\Select::make('type')
                ->default('page')
                ->options([
                    'url' => 'URL',
                    'path' => 'Path',
                    'page' => 'Page',
                    // 'form' => 'Form',
                ])->live(),

            Forms\Components\TextInput::make('url')
                ->label('URL')
                ->hidden(fn (Get $get) => in_array($get('type'), ['page', 'form'])),

            Forms\Components\Select::make('url')
                ->label('URL')
                ->options(
                    fn (Get $get) => match ($get('type')) {
                        'form' => Schema::orderBy('name')->get()->pluck('name', 'url')->toArray(),
                        'page' => Page::orderBy('title')->pluck('title', 'slug')->toArray(),
                    }
                )
                ->searchable()
                ->preload()
                ->hidden(fn (Get $get) => ! in_array($get('type'), ['page', 'form'])),
        ];

        return $form
            ->schema([
                ...$formSchema,
                Forms\Components\Repeater::make('childs')
                    ->collapsible()
                    ->label('Sub Navigasi')
                    ->addActionLabel('Tambah Sub Navigasi')
                    ->defaultItems(0)
                    ->schema([
                        ...$formSchema,
                        Forms\Components\Repeater::make('childs')
                            ->label('Sub Navigasi')
                            ->addActionLabel('Tambah Sub Navigasi')
                            ->defaultItems(0)
                            ->collapsible()
                            ->schema([
                                ...$formSchema,
                            ]),
                    ]),
            ])->columns(1);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->paginated(false)
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name'),
                        Tables\Columns\TextColumn::make('url')
                            ->color('gray')
                            ->size('sm'),
                    ]),
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('updated_at')
                            ->dateTime('d/m/Y H:i:s')
                            ->description('Updated At', 'above'),
                    ])->grow(false),
                ]),
            ])
            ->filters([
                Tables\Filters\Filter::make('induk')
                    ->toggle()
                    ->query(fn ($query) => $query->parentOnly()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth('lg'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            NavigationsStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigation::route('/create'),
            'edit' => Pages\EditNavigation::route('/{record}/edit'),
        ];
    }
}
