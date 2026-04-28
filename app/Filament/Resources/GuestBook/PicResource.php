<?php

namespace App\Filament\Resources\GuestBook;

use App\Filament\Resources\GuestBook\PicResource\Pages;
use App\Models\GuestBook\Pic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kedeka\Whatsapp\Rules\OnWhatsApp;
use Livewire\Attributes\Rule;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneInputColumn;

class PicResource extends Resource
{
    protected static ?string $model = Pic::class;

    protected static ?string $navigationIcon = 'carbon-user-admin';

    protected static ?string $navigationGroup = 'Guest Books';

    protected static bool $shouldRegisterNavigation = false;

    #[Rule('required')]
    public $nama = '';

    #[Rule(['required', new OnWhatsApp])]
    public $phone = '';

    #[Rule('required')]
    public $pesan = '';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('position')
                    ->required(),
                PhoneInput::make('phone')
                    ->label('WhatsApp Number')
                    ->separateDialCode()
                    ->required()
                    ->rule(new OnWhatsApp)
                    ->defaultCountry('ID'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->wrap()
                    ->searchable(['name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                PhoneInputColumn::make('phone')
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
                    Tables\Actions\EditAction::make()
                        ->modalWidth('lg'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePics::route('/'),
        ];
    }
}
