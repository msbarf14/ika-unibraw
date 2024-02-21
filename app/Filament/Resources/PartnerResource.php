<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\Widgets\PartnersStats;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'carbon-partnership';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('phone'),
                        Forms\Components\TextInput::make('email'),
                        Forms\Components\TextInput::make('website'),
                        Forms\Components\Textarea::make('address'),
                    ])->columnSpan(4),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Fieldset::make()->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->content(fn (Model $record) => $record?->created_at?->isoFormat('dddd, DD MMMM Y H:mm z')),
                            Forms\Components\Placeholder::make('updated_at')
                                ->content(fn (Model $record) => $record?->updated_at?->isoFormat('dddd, DD MMMM Y H:mm z')),
                        ])
                            ->columns(1)
                            ->hiddenOn('create')
                            ->extraAttributes([
                                'class' => 'dark:bg-white/5',
                            ]),

                        SpatieMediaLibraryFileUpload::make('image')
                            ->disk('upcloud')
                            ->image()
                            ->collection('images')
                            ->preserveFilenames(),

                    ])->columnSpan(2),
                ])->columnSpanFull(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('images')
                    ->grow(false),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable([
                        'name',
                        'phone',
                        'email',
                        'website',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->grow(false)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->grow(false)
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
            PartnersStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
