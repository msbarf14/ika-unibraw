<?php

namespace App\Filament\Pages;

use App\Models\Setting as Model;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Setting extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'carbon-information';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Umum';

    protected static string $view = 'filament.pages.setting';

    public function mount(): void
    {
        $this->form->fill(
            [
                'operator' => [],
                'whatsapp' => [
                    'footer' => '',
                ],

                ...Model::where('key', 'operator')->pluck('value', 'key')->map(fn ($item) => json_decode($item, true))->toArray(),
                ...Arr::undot(Model::query()
                    ->where('key', 'LIKE', 'whatsapp.%')
                    ->orWhere('key', 'LIKE', 'greeting.%')
                    ->pluck('value', 'key')
                    ->toArray()),
            ]
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Operator')
                    ->schema([
                        Forms\Components\Repeater::make('operator')->schema([
                            Forms\Components\TextInput::make('phone')
                                ->label('Nomor WhatsApp')
                                ->inlineLabel()
                                ->required()
                                ->columnSpanFull(),
                        ])
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->defaultItems(3),
                    ])->extraAttributes([
                        'class' => 'bg-white dark:bg-gray-800',
                    ]),

                Forms\Components\Fieldset::make('WhatsApp')
                    ->schema([
                        Forms\Components\Textarea::make('whatsapp.footer')
                            ->label('Footer')
                            ->inlineLabel()
                            ->required()
                            ->columnSpanFull()
                            ->rows(8),
                    ])->extraAttributes([
                        'class' => 'bg-white dark:bg-gray-800',
                    ]),

                Forms\Components\Fieldset::make('Greeting')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\FileUpload::make('greeting.photo')
                                ->deleteUploadedFileUsing(fn ($file) => Storage::disk('upcloud')->delete($file))
                                ->image()
                                ->disk('upcloud')
                                ->optimize('png')
                                ->downloadable(),
                            Forms\Components\Group::make([
                                Forms\Components\Textarea::make('greeting.message')
                                    ->label('Sambutan')
                                    ->rows(5),
                                Forms\Components\TextInput::make('greeting.speaker')
                                    ->label('Nama'),
                                Forms\Components\TextInput::make('greeting.occupation')
                                    ->label('Jabatan'),
                            ])->columns(1)->columnSpan(2),
                        ]),
                    ])
                    ->columns(1)
                    ->extraAttributes([
                        'class' => 'bg-white dark:bg-gray-800',
                    ]),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $input = $this->form->getState();

        Model::firstOrCreate(['key' => 'operator'])->update([
            'value' => $input['operator'] ?? [],
        ]);

        foreach (Arr::dot(Arr::except($input, 'operator')) as $key => $value) {
            Model::firstOrCreate([
                'key' => $key,
            ])->update([
                'value' => $value,
            ]);
        }

        Notification::make()
            ->title('Pengaturan Umum berhasil disimpan')
            ->success()
            ->send();
    }
}
