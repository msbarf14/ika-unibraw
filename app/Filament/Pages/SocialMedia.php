<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Arr;

class SocialMedia extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'carbon-share';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Sosial Media';

    protected static string $view = 'filament.pages.social-media';

    public function mount(): void
    {
        $this->form->fill(
            Arr::undot(Setting::query()
                ->where('key', 'LIKE', 'social-media.%')
                ->pluck('value', 'key')
                ->toArray())
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Social Media')
                    ->hiddenLabel()
                    ->schema([
                        Forms\Components\TextInput::make('social-media.facebook')
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->suffixIcon('si-facebook'),
                        Forms\Components\TextInput::make('social-media.instagram')
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->suffixIcon('si-instagram'),
                        Forms\Components\TextInput::make('social-media.twitter')
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->suffixIcon('carbon-logo-x'),
                        Forms\Components\TextInput::make('social-media.youtube')
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->suffixIcon('si-youtube'),
                        Forms\Components\TextInput::make('social-media.tiktok')
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->suffixIcon('si-tiktok')
                    ])->extraAttributes([
                        'class' => 'bg-white dark:bg-gray-800',
                    ]),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $input = $this->form->getState();

        foreach (Arr::dot($input) as $key => $value) {
            Setting::firstOrCreate([
                'key' => $key,
            ])->update([
                'value' => $value,
            ]);
        }

        Notification::make()
            ->title('Social Media berhasil disimpan')
            ->success()
            ->send();
    }
}
