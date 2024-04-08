<?php

namespace App\Livewire\Web\Donasi;

use App\Filament\Forms\Components\NumberInput;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Donasi\Campaign as Model;
use App\Models\Donasi\Transaction as DonasiTransaction;
use App\Models\Setting;
use Closure;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Kedeka\Whatsapp\OnWhatsApp;
use App\Jobs\SendMessage;
use Kedeka\Whatsapp\Enums\MessageType;

class Detail extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Model $campaign;
    public ?array $data = [];


    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama.')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('No. Tlp (Whatsapp)')
                    ->helperText('Pastikan nomer terdaftar di aplikasi whatsapp.')
                    ->required()
                    ->rules([
                        fn (): Closure => function (?string $attribute, $value, Closure $fail) {
                            if (App::environment('production')) {
                                if (!app(OnWhatsApp::class)->check($value)) {
                                    $fail('Bukan Nomor WhatsApp Aktif.');
                                }
                            }
                        },
                    ]),
                NumberInput::make('amount')
                    ->helperText('Nomial donasi yang di transfer.')
                    ->label('Jumlah')
                    ->required(),
                Forms\Components\FileUpload::make('attachment')
                    ->label('Bukti Transfer')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('donasi_trasaction'),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->label('Pesan')
                    ->helperText('Ucapan pesan/doa.'),
            ])
            ->statePath('data');
    }
    public function create(): void
    {
        $body = $this->form->getState();
        DB::beginTransaction();
        try {
            DonasiTransaction::create([
                'campaign_id' => $this->campaign->id,
                'name' => $body['name'],
                'phone' => $body['phone'],
                'message' => $body['message'],
                'attachment' => $body['attachment'],
                'amount' => $body['amount'],
                'paid' => 0,
            ]);
            $this->message($body['name']);
            DB::commit();
            Notification::make()
                ->title('Berahasil ! Terimakasih telah melakukan donasi.')
                ->success()
                ->send();
            $this->form->fill();
        } catch (\Throwable $th) {
            dd($th);
            Notification::make()
                ->title('Terjadi kesalahan! coba lagi.')
                ->danger()
                ->send();
            DB::rollBack();
        }
    }

    public function message(?string $name)
    {
        $message['text'] = sprintf('*%s telah mengirim untuk program %s di %s*',$name, $this->campaign->title, url('/'))
            . PHP_EOL
            . PHP_EOL;

        $settings = Arr::undot(Setting::pluck('value', 'key'));
        $stringOperator = implode(',', array_map(fn ($value) => $value['phone'] ?? null, json_decode($settings['operator'], true)));
        if (empty($stringOperator)) {
            $operator = config('whatsapp.receipts');
        } else {
            $operator = explode(',', $stringOperator);
        }

        foreach ($operator as $index => $number) {
            $phone = $number; // this need to be dynamic for different operator
            SendMessage::dispatch($number, $message, MessageType::Text)->delay(now()->addSeconds($index + 2));
        }
    }

    #[Layout('components.layouts.web')]
    public function render()
    {
        return view('livewire.web.donasi.detail', [
            'donasi' => $this->campaign
        ])
            ->title($this->campaign->title);
    }
}
