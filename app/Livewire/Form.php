<?php

namespace App\Livewire;

use App\Models\Form\Schema;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Schema $schema;

    public function mount(Schema $schema): void
    {
        $this->schema = $schema;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        $schema = [];

        foreach ($this->schema->schema as $item) {

            $label = $item['name'];
            $required = $item['required'] ?? false;
            $key = Str::of($label)->replaceMatches(pattern: '/[^A-Za-z0-9\ ]++/', replace: ' ')->lower()->snake();
            $options = Arr::pluck($item['options'], 'label', 'value');
            $type = $item['type'];

            if ($type === 'multiple-choice') {
                $schema[] = Forms\Components\Radio::make($key)
                    ->label($label)
                    ->options($options)
                    ->required($required)
                    ->columnSpan('full');
            }

            if ($type === 'dropdown') {
                $schema[] = Forms\Components\Select::make($key)
                    ->label($label)
                    ->options($options)
                    ->required($required)
                    ->columnSpan('full');
            }

            if ($type === 'dropdown:area') {
                $districts = collect(config('districts'));

                $schema[] = Forms\Components\Select::make('kecamatan')
                    ->label('Kecamatan')
                    ->options($districts->pluck('label', 'id'))
                    ->live()
                    ->required(true);

                $schema[] = Forms\Components\Select::make('kelurahan')
                    ->label('Kelurahan')
                    ->options(fn (Get $get) => Arr::pluck($districts->where('id', $get('kecamatan'))?->first()['childs'] ?? [], 'label', 'id'))
                    ->required(true);
            }

            if (in_array($type, ['textinput', 'textinput:phone', 'textinput:nik', 'textinput:email'])) {
                $isEmail = $type === 'textinput:email';
                $maskNumber = '9999999999999999';

                $schema[] = Forms\Components\TextInput::make($key)
                    ->label($label)
                    ->required($required)
                    ->email($isEmail)
                    ->mask(fn () => in_array($type, ['textinput:phone', 'textinput:nik']) ? $maskNumber : null)
                    ->columnSpan('full');
            }

            if ($type === 'textarea') {
                $schema[] = Forms\Components\Textarea::make($key)
                    ->label($label)
                    ->required($required)
                    ->columnSpan('full');
            }
        }

        return $form
            ->schema([
                ...$schema,
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        Notification::make()
            ->title('Berhasil')
            ->body("Data {$this->schema->name} kamu sudah kami terima!")
            ->success()
            ->send();

        $this->schema->collections()->create(['data' => $data]);

        $this->form->fill([]);
    }

    public function render(): View
    {
        return view('livewire.form');
    }
}
