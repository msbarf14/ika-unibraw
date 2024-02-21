<?php

namespace App\Filament\Resources\GuestBook;

use App\Filament\Resources\GuestBook\EntryResource\Pages;
use App\Models\GuestBook\Entry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneInputColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class EntryResource extends Resource
{
    protected static ?string $model = Entry::class;

    protected static ?string $navigationIcon = 'carbon-chat-launch';

    protected static ?string $navigationGroup = 'Guest Books';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                PhoneInput::make('phone')
                    ->required()
                    ->separateDialCode()
                    ->defaultCountry('ID'),
                Forms\Components\Textarea::make('needs')
                    ->required()
                    ->label('Keperluan')
                    ->autosize(),
                Forms\Components\TextInput::make('agency')
                    ->label('Instansi')
                    ->placeholder('Instansi Anda')
                    ->required(),
                Forms\Components\Select::make('pic_id')
                    ->relationship('pic', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->position})")
                    ->searchable()
                    ->preload(),
                Forms\Components\DatePicker::make('date')
                    ->native(false)
                    ->label('Tanggal')
                    ->suffixIcon('carbon-calendar')
                    ->default(now()),
                Forms\Components\Select::make('at')
                    ->options(function (): array {
                        $options = [];

                        $time = now()->hour(7)->startOfHour();

                        while ($time < now()->hour(17)->startOfHour()->addMinute()) {
                            $options[$time->format('H:i')] = $time->format('H:i A');

                            $time->addMinutes(5);
                        }

                        return $options;
                    })
                    ->label('Waktu')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(-1),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\Fieldset::make()->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->content(fn (Model $record) => $record?->created_at?->isoFormat('dddd, DD MMMM Y H:mm z')),
                        Forms\Components\Placeholder::make('updated_at')
                            ->content(fn (Model $record) => $record?->updated_at?->isoFormat('dddd, DD MMMM Y H:mm z')),
                    ])->columns(1)
                        ->hiddenOn('create')
                        ->extraAttributes([
                            'class' => 'dark:bg-white/5',
                        ]),
                ])->columnSpan(1),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(['name', 'phone', 'agency'])
                    ->sortable(),
                PhoneInputColumn::make('phone')
                    ->sortable(),
                Tables\Columns\TextColumn::make('agency')
                    ->sortable(),
                Tables\Columns\TextColumn::make('needs')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                 
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime('l, F/d/Y')
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('phone'),
                TextEntry::make('agency'),
                TextEntry::make('needs')
                    ->label('Keperluan'),
                TextEntry::make('date')
                    ->dateTime('l, F/d/Y'),
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEntries::route('/'),
        ];
    }
}
