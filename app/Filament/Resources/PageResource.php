<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\Widgets\PagesStats;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'carbon-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\TextInput::make('title')
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug'),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->image()
                            ->disk('upcloud')
                            ->collection('images')
                            ->preserveFilenames(),
                        SpatieMediaLibraryFileUpload::make('documents')
                            ->multiple()
                            ->disk('upcloud')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'text/plain',
                                'text/html',
                                'text/csv',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->collection('documents')
                            ->preserveFilenames(),
                        TiptapEditor::make('content')
                            ->profile('simple'),
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
                    ->searchable(['title', 'content'])
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
            PagesStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
