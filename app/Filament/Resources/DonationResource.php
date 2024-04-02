<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\NumberInput;
use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Donasi\Campaign as Donation;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Donasi';
    protected static ?string $navigationLabel = 'Campaign';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->imageEditor()
                    ->imageEditorMode(2)
                    ->label('Thumbnail')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('images'),
                Forms\Components\TextInput::make('title'),
                NumberInput::make('amount')
                    ->required(),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Toggle::make('open'),
                Forms\Components\Toggle::make('display_amount'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->prefix('Rp. ')
                    ->numeric(),
                Tables\Columns\IconColumn::make('open')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->alignEnd(),
                Tables\Columns\IconColumn::make('display_amount')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->alignEnd(),
                // Tables\Columns\TextColumn::make('')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Campaign')
                    ->description('Title, description, amount, ect.')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->size('lg'),
                        Infolists\Components\TextEntry::make('amount')
                            ->size('lg')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('description')
                            ->size('lg')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('open')
                            ->getStateUsing(fn ($record) => $record->open ? 'DIBUKA' : 'TUTUP')
                            ->helperText('Donasi dibuka untuk umum.')
                            ->weight('bold')
                            ->size('lg'),
                        Infolists\Components\TextEntry::make('display_amount')
                            ->getStateUsing(fn ($record) => $record->display_amount ? 'TAMPILKAN' : 'SEMBUNYIKAN')
                            ->helperText('Tampilkan jumlah target donasi.')
                            ->weight('bold')
                            ->size('lg'),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'view' => Pages\ViewDonation::route('/{record}/detail'),
            // 'create' => Pages\CreateDonation::route('/create'),
            // 'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
