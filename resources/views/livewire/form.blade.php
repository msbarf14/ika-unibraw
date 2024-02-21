@php
    $color = data_get($schema?->meta, 'color', null);
    $bgColor = str_replace(['rgb', ')'], ['rgba', ', 0.1)'], $color);
@endphp

<div 
    @style([
        'background-color: '.$bgColor
    ])
    class="min-h-screen"
>
    @if (data_get($schema?->meta, 'using_layout', false))
        <x-shared.navigation />
    @endif
    <div class="max-w-3xl p-6 mx-auto space-y-6">
        @if ($schema->getFirstMediaUrl('header_image') && !data_get($schema?->meta, 'using_layout', false))
            <img src="{{ $schema->getFirstMediaUrl('header_image') }}" alt="{{ $schema?->name }}" srcset="">
        @endif
        <div>
            <h2 class="text-xl font-bold text-center">{{ $schema?->name }}</h2>
        </div>
        <form wire:submit="submit">
            {{ $this->form }}

            @if($this->hasOtp)
                @if($this->hasRequestOtp)
                <div class="mt-5 text-sm text-gray-500" wire:key="{{ md5($otpExpires) }}">
                    <x-otp-countdown :expires="$otpExpires">
                        <span x-text="timer.minutes">{{ $component->minutes() }}</span> menit
                        <span x-text="timer.seconds">{{ $component->seconds() }}</span> detik
                    </x-otp-countdown>
                </div>

                    @if($this->otpExpired)
                    <div class="text-xs font-medium text-danger-600 dark:text-danger-400">
                        Kode OTP kamu sudah expired silakan, minta ulang kode OTP.
                    </div>
                    @endif
                @endif
            @endif

            @error('otpPhoneNumber')
                <div class="mt-5 text-xs font-medium text-danger-600 dark:text-danger-400">{{ $message }}</div>
            @enderror

            <div class="flex items-center mt-6 space-x-5">

                @if($this->hasOtp)
                <x-filament::button size="lg" type="button" color="gray" wire:click="requestOtp" wire:target="requestOtp" :disabled="$this->hasRequestOtp && !$this->otpExpired">
                    Minta Kode OTP
                </x-filament::button>
                @endif

                <x-filament::button size="lg" @style([
                    'background-color:'. $color
                ]) type="submit" :disabled="($this->hasOtp && !$this->hasRequestOtp) || $this->otpExpired" wire:target="submit">
                    Kirim
                </x-filament::button>
            </div>
        </form>
    </div>

    <x-filament-actions::modals />
    @if (data_get($schema?->meta, 'using_layout', false))
        <x-shared.footer />
    @endif
</div>
