<?php

namespace App\Filament\Resources\DonationResource\RelationManagers;

use App\Filament\Forms\Components\NumberInput;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CampaignRelationManager extends RelationManager
{
    protected static string $relationship = 'transaction';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('attachment')
                    ->required()
                    ->disk('public')
                    ->image()
                    ->directory('donation'),
                NumberInput::make('amount')
                    ->required(),
                Forms\Components\Toggle::make('paid')
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('message')
                    ->wrap(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->summarize(Sum::make()->label('Total')),
                Tables\Columns\IconColumn::make('paid')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('paid')
                    ->options([
                        0 => 'Unpaid',
                        1 => 'Paid',
                    ])
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('paid')
                        ->label('Mark As Paid')
                        ->icon('heroicon-o-cursor-arrow-ripple')
                        ->action(function($record) {
                            $record->update([
                                'paid' => 1
                            ]);

                            Notification::make()
                                ->title('Sukses')
                                ->send()
                                ->success();
                        })
                        ->requiresConfirmation(),
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
}
