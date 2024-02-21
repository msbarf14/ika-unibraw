<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\Widgets\SlidersStats;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'carbon-image';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\TextInput::make('link'),
                        Forms\Components\Radio::make('type')
                            ->default('internal')
                            ->options([
                                'internal' => 'Internal',
                                'external' => 'External',
                            ])->inline(),
                        SpatieMediaLibraryFileUpload::make('background')
                            ->disk('public')
                            ->collection('backgrounds'),
                        SpatieMediaLibraryFileUpload::make('illustration')
                            ->disk('public')
                            ->collection('illustrations'),
                        Forms\Components\Textarea::make('description'),
                        Forms\Components\Select::make('button_style')
                            ->default('orange')
                            ->options([
                                'orange' => 'Orange',
                                'blue' => 'Blue',
                                'blue-2' => 'Blue 2',
                                'green' => 'Green',
                                'white' => 'White',
                                'black' => 'Black',
                            ]),
                    ])->columnSpan(4),
                    Forms\Components\Fieldset::make()->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->content(fn (Model $record) => $record?->created_at?->isoFormat('dddd, DD MMMM Y H:mm z')),
                        Forms\Components\Placeholder::make('updated_at')
                            ->content(fn (Model $record) => $record?->updated_at?->isoFormat('dddd, DD MMMM Y H:mm z')),
                    ])->columns(1)->columnSpan(2)->hiddenOn('create')->extraAttributes([
                        'class' => 'dark:bg-white/5',
                    ]),
                ])->columnSpanFull(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->searchable(['title', 'description'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->wrap()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
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

    public static function getWidgets(): array
    {
        return [
            SlidersStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
