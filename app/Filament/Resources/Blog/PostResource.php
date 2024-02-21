<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostResource\Pages;
use App\Filament\Resources\Blog\PostResource\Widgets\PostsStats;
use App\Models\Blog\Post;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'carbon-document-multiple-01';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\TextInput::make('title')
                            ->live(debounce: 300)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug'),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->collection('images')
                            ->preserveFilenames(),
                        TiptapEditor::make('content')
                            ->disk('public')
                            ->profile('simple'),
                    ])->columnSpan(4),

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
                        Forms\Components\Fieldset::make()->schema([
                            Forms\Components\Select::make('author_id')
                                ->relationship('author', 'name')
                                ->searchable()
                                ->preload(),
                            Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload(),
                            Forms\Components\TagsInput::make('tags'),
                            Forms\Components\Hidden::make('published_at'),
                            Forms\Components\DateTimePicker::make('published_at')
                                ->default(fn (?Model $record, ?string $operation) => $operation === 'create' ? now()->startOfDay() : $record?->published_at)
                                ->native(false)
                                ->hidden(fn (Get $get) => $get('published') === false),
                            Forms\Components\Toggle::make('published')
                                ->live()
                                ->afterStateHydrated(fn (Toggle $component, ?Model $record, ?string $operation) => $component->state(($operation === 'create' ? true : ($record?->published_at ? true : false))))
                                ->afterStateUpdated(fn (Set $set, bool $state) => $set('published_at', $state ? now()->startOfDay() : null)),
                        ])->columns(1)
                            ->extraAttributes([
                                'class' => 'dark:bg-white/5',
                            ]),
                    ])->columnSpan(2),
                ])->columnSpanFull(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->searchable(['title', 'content', 'slug'])
                    ->formatStateUsing(fn (Model $record, ?string $state) => new HtmlString(<<<BLADE
                        <div>
                            $state
                        </div>
                        <div class="text-xs text-gray-500">{$record->slug}</div>
                    BLADE))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'Published',
                        'warning' => 'Draft',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
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
            ->defaultSort('published_at', 'desc');
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
            PostsStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
