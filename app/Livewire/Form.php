<?php

namespace App\Livewire;

use App\Models\Form\Schema;
use Closure;
use DateTimeInterface;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Kedeka\Whatsapp\OnWhatsApp;
use Kedeka\WhatsappOtp\Valid;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Schema $schema;

    public bool $hasOtp = false;

    public bool $hasRequestOtp = false;

    public bool $otpExpired = false;

    public ?DateTimeInterface $otpExpires;

    public ?string $otpKey = null;

    public ?string $otpPhoneNumber = null;

    public function mount(Schema $schema): void
    {
        $this->schema = $schema;
    }

    #[On('otp-expired')]
    public function otpExpired()
    {
        $this->otpExpired = true;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        $schemaStart = [];
        $schema = [];
        $schemaEnd = [];

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
                $isOtp = $type === 'textinput:phone' && ($item['otp'] ?? false);
                $maskNumber = '9999999999999999';

                $schema[] = Forms\Components\TextInput::make($key)
                    ->label($label)
                    ->required($required)
                    ->email($isEmail)
                    ->mask(fn () => in_array($type, ['textinput:phone', 'textinput:nik']) ? $maskNumber : null)
                    ->live($isOtp)
                    ->afterStateUpdated(function (?string $state) use ($isOtp) {
                        if ($isOtp) {
                            $this->otpPhoneNumber = $state;
                        }
                    })
                    ->columnSpan('full');

                if ($isOtp) {
                    $this->hasOtp = true;
                    $this->otpKey = $key;

                    $schemaEnd[] = Forms\Components\TextInput::make('otp')
                        ->hint('Periksa Whatsapp kamu untuk melihat kode OTP')
                        ->label('OTP')
                        ->validationAttribute('OTP')
                        ->mask('9999')
                        ->maxLength(4)
                        ->columnSpanFull()
                        ->rules([
                            fn () => function (string $attribute, $value, Closure $fail) {
                                if (! app(Valid::class)->check($this->otpPhoneNumber, now(), $value)) {
                                    $fail('Kode OTP tidak valid');
                                }
                            },
                        ])
                        ->required()
                        ->disabled(fn () => ! $this->hasRequestOtp || $this->otpExpired);
                }
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
                ...$schemaStart,
                ...$schema,
                ...$schemaEnd,
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function requestOtp()
    {
        if (! app(OnWhatsApp::class)->check($this->otpPhoneNumber)) {
            Notification::make()
                ->title('Nomor WhatsApp tidak valid')
                ->body('Periksa Kembali Nomor WhatsApp yang kamu masukkan')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'otpPhoneNumber' => 'Nomor WhatsApp tidak valid',
            ]);
        }

        $this->hasRequestOtp = true;
        $this->otpExpired = false;
        $this->otpExpires = now()->addSeconds(30);

        app(\Kedeka\WhatsappOtp\Ask::class)->otp($this->otpPhoneNumber, $this->otpExpires);

        Notification::make()
            ->title('Request OTP')
            ->body('Kode OTP sudah dikirim, silakan periksa whatsapp mu')
            ->success()
            ->send();
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

        $this->hasRequestOtp = false;
        $this->otpExpired = false;
        $this->otpExpires = null;
        $this->otpPhoneNumber = null;
    }

    public function render(): View
    {
        return view('livewire.form');
    }
}
