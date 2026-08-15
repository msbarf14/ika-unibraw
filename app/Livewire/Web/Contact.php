<?php

namespace App\Livewire\Web;

use App\Models\Contact as Model;
use App\Models\Setting;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Contact extends Component
{
    #[Rule('required')]
    public $nama = '';

    #[Rule('required')]
    public $phone = '';

    #[Rule('required')]
    public $pesan = '';

    public function render()
    {
        $settings = Arr::undot(Setting::where('key', 'LIKE', 'social-media.%')->pluck('value', 'key'))['social-media'] ?? [];

        return view('livewire.web.contact', [
            'social' => $settings,
        ]);
    }

    public function submit()
    {
        $validated = $this->validate();
        $phoneValidated = preg_replace('/[^0-9]/', '', $validated['phone']);

        $contact = Model::create([
            'name' => $validated['nama'],
            'phone' => $phoneValidated,
            'message' => $validated['pesan'],
        ]);

        $this->reset();

        Notification::make()
            ->title('Berhasil')
            ->body('Pesan anda berhasil terkirim')
            ->color('success')
            ->success()
            ->send();
    }
}
