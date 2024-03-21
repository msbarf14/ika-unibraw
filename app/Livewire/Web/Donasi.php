<?php

namespace App\Livewire\Web;

use App\Jobs\SendMessage;
// use App\Models\Contact as Model;
// use App\Models\Setting;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Kedeka\Whatsapp\Enums\MessageType;
use Kedeka\Whatsapp\Rules\OnWhatsApp;
use Kedeka\WhatsappOtp\Rules\Valid;
use Livewire\Attributes\Rule;
use Livewire\Component;


class Donasi extends Component
{
    #[Rule('required')]
    public $nama = '';

    #[Rule(['required', new OnWhatsApp])]
    public $phone = '';

    #[Rule('required')]
    public $pesan = '';

    public $otp = '';

    public $timer = 0;

    public $active = false;

    public function render()
    {
        return view('livewire.web.donasi');
    }

    public function submit()
    {
        $validated = $this->validate();
        $phoneValidated = preg_replace('/[^0-9]/', '', $validated['phone']);
        $otp = $this->validate([
            'otp' => ['required', new Valid($phoneValidated, now()->toString())],
        ], attributes: ['otp' => 'OTP']);

        // $contact = Model::create([
        //     'name' => $validated['nama'],
        //     'phone' => $phoneValidated,
        //     'message' => $validated['pesan'],
        // ]);

        $message['text'] = sprintf('*%s telah mengirim pesan pada %s*', $validated['nama'], url('/'))
        .PHP_EOL
        .PHP_EOL
        .sprintf('%s', $validated['pesan'])
        .PHP_EOL
        .PHP_EOL
        .sprintf('Nomor wa : %s', $phoneValidated);

        $country_code = substr($phoneValidated, 0, 2 - strlen($phoneValidated));
        $phone_number = substr($phoneValidated, 2);
        if ($country_code == '08') {
            $country_code = '+628';
        }

        $message['templateButtons'][] = [
            'label' => sprintf('Hubungi %s', $validated['nama']),
            'type' => 'call',
            'phone' => sprintf('%s%s', $country_code, $phone_number),
        ];

        $settings = Arr::undot(Setting::pluck('value', 'key'));
        $stringOperator = implode(',', array_map(fn ($value) => $value['phone'] ?? null, json_decode($settings['operator'], true)));
        if (empty($stringOperator)) {
            $operator = config('whatsapp.receipts');
        } else {
            $operator = explode(',', $stringOperator);
        }

        // for send contact
        $contact = substr(sprintf('%s%s', $country_code, $phone_number), 1); // contact whatsapp number, must start with country code eg. 62, static
        $name = $validated['nama']; // required

        foreach ($operator as $index => $number) {
            $phone = $number; // this need to be dynamic for different operator
            SendMessage::dispatch($number, $message, MessageType::Text, compact('phone', 'contact', 'name'))->delay(now()->addSeconds($index + 2));
        }

        $this->reset();

        Notification::make()
            ->title('Berhasil')
            ->body('Pesan anda berhasil terkirim')
            ->color('success')
            ->success()
            ->send();
    }

    public function getOtp()
    {
        $timestamp = now()->toString();
        $validated = $this->validateOnly('phone');

        $time = app(\Kedeka\WhatsappOtp\Ask::class)->otp($validated['phone'], $timestamp);
        $this->active = true;
        $this->timer = $time['timer'];
    }
}
