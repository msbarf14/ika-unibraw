<?php

namespace App\Filament\Resources\Form;

use App\Filament\Resources\Form\SchemaResource\Pages;
use App\Models\Form\Schema;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class SchemaResource extends Resource
{
    protected static ?string $model = Schema::class;

    protected static ?string $navigationIcon = 'carbon-data-1';

    protected static ?string $navigationGroup = 'Form';
    protected static bool $shouldRegisterNavigation = false;
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => [
                        $set('slug', Str::slug($state)),
                        $set('meta.navigation_label', $state),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                Forms\Components\TextInput::make('meta.navigation_label')
                    ->label('Navigation Label')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('meta.using_layout')
                    ->label('Using Layout')
                    ->default(true)
                    ->live()
                    ->columnSpanFull(),
                Forms\Components\ColorPicker::make('meta.color')
                    ->label('Color')
                    ->hidden(fn (Get $get) => $get('meta.using_layout'))
                    ->rgb()
                    ->columnSpanFull(),
                Forms\Components\SpatieMediaLibraryFileUpload::make('header_image')
                    ->collection('header_image')
                    ->label('Header Image')
                    ->disk('upcloud')
                    ->image()
                    ->imageEditor()
                    ->hidden(fn (Get $get) => $get('meta.using_layout'))
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('schema')->schema([
                    Forms\Components\TextInput::make('name')
                        ->columnSpan(3),
                    Forms\Components\Select::make('type')
                        ->live()
                        ->options([
                            'textinput' => 'Short Text',
                            'textarea' => 'Long Text',
                            'textinput:email' => 'Email',
                            'textinput:phone' => 'Phone',
                            'textinput:nik' => 'NIK',
                            'dropdown' => 'Dropdown',
                            'dropdown:area' => 'Kelurahan & Kecamatan',
                            'multiple-choice' => 'Multiple Choice',
                        ]),
                    Forms\Components\Toggle::make('required'),
                    Forms\Components\Toggle::make('show-in-table'),
                    Forms\Components\Toggle::make('otp')
                        ->label('OTP')
                        ->hidden(fn (Get $get) => ! in_array($get('type'), ['textinput:phone'])),
                    Forms\Components\Repeater::make('options')
                        ->schema([
                            Forms\Components\TextInput::make('value'),
                            Forms\Components\TextInput::make('label'),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->hidden(fn (Get $get) => ! in_array($get('type'), ['dropdown', 'multiple-choice'])),
                ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('collections'))
            ->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn (Model $record, ?string $state) => new HtmlString(<<<BLADE
                        <div>
                            $state
                        </div>
                        <div class="text-xs text-gray-500">{$record->slug}</div>
                    BLADE))
                    ->searchable([
                        'name',
                        'slug',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('url')
                    ->getStateUsing('Link')
                    ->icon('carbon-launch')
                    ->iconPosition('after')
                    ->url(fn (Model $record) => $record->url, shouldOpenInNewTab: true),

                Tables\Columns\TextColumn::make('collections_count')
                    ->label('Collections')
                    ->icon('carbon-table')
                    ->iconPosition('after')
                    ->url(fn (Model $record) => CollectionResource::getUrl('index', ['schema' => $record->id])),

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
            ])
            ->defaultSort('sort');
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
            'index' => Pages\ListSchemas::route('/'),
            'create' => Pages\CreateSchema::route('/create'),
            'edit' => Pages\EditSchema::route('/{record}/edit'),
        ];
    }
}
