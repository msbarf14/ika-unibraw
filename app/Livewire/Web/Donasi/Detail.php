<?php

namespace App\Livewire\Web\Donasi;

use App\Filament\Forms\Components\NumberInput;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Donasi\Campaign as Model;
use App\Models\Donasi\Transaction as DonasiTransaction;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

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
                    ->rules(['required']),
                NumberInput::make('amount')
                    ->helperText('Nomial donasi yang di transfer.')
                    ->label('Jumlah')
                    ->required(),
                Forms\Components\FileUpload::make('attachment')
                    ->label('Bukti Transfer')
                    ->image()
                    ->required()
                    ->disk(config('filesystems.default'))
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
            DB::commit();
            Notification::make()
                ->title('Berhasil ! Terimakasih telah melakukan donasi.')
                ->success()
                ->color('success')
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

    #[Layout('components.layouts.web')]
    public function render()
    {
        return view('livewire.web.donasi.detail', [
            'donasi' => $this->campaign,
            'details' => DonasiTransaction::where('campaign_id', $this->campaign->id)
                ->where('paid', 1)
                ->latest()
                ->take(30)
                ->get(),
            'total_amount' => DonasiTransaction::where('campaign_id', $this->campaign->id)
                ->where('paid', 1)
                ->sum('amount')
        ])
            ->title($this->campaign->title);
    }
}
