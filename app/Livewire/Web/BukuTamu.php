<?php

namespace App\Livewire\Web;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use App\Models\GuestBook\Entry;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Title;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class BukuTamu extends Component implements HasForms
{

    use InteractsWithForms;
    protected static ?string $model = Entry::class;

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
                    ->required(),
                PhoneInput::make('phone')
                    ->required()->label("WhatsApp Number")
                    ->separateDialCode()
                    ->defaultCountry('ID'), // Default Number Indonesian
                Forms\Components\Textarea::make('needs')
                    ->required()
                    ->label('Keperluan')
                    ->autosize(),
                Forms\Components\TextInput::make('agency')
                    ->label('Instansi')
                    ->placeholder('Instansi Anda')
                    ->required(),
                Forms\Components\Select::make('pic_id')
                    ->relationship('pic', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->position})")
                    ->searchable()
                    ->preload()->required(),
                Forms\Components\DatePicker::make('date')
                    ->native(false)
                    ->label('Tanggal')
                    ->suffixIcon('carbon-calendar')
                    ->default(now())->required(),
                Forms\Components\Select::make('at')->required()
                    ->options(function (): array {
                        $options = [];

                        $time = now()->hour(7)->startOfHour();

                        while ($time < now()->hour(17)->startOfHour()->addMinute()) {
                            $options[$time->format('H:i')] = $time->format('H:i A');

                            $time->addMinutes(5);
                        }

                        return $options;
                    })
                    ->label('Waktu')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(-1),

            ])
            ->statePath('data')->model(Entry::class);
    }

    public function create(): void
    {

        $state = $this->form->getState();

        $guestBookEntry = Entry::create($state);

        // Save the relationships from the form to the post after it is created.
        $this->form->model($guestBookEntry)->saveRelationships();
        Notification::make()
            ->title('Terima Kasih atas Partisipasi Anda!')
            ->body('Kami ingin menyampaikan terima kasih atas kunjungan Anda dan pengisian data di Buku Tamu kami. Kontribusi Anda sangat berarti bagi kami.')
            ->success()
            ->send();

        $this->form->fill([]);

    }

    #[Title('Buku Tamu')]
    public function render()
    {
        return view('livewire.web.buku-tamu');
    }
}
