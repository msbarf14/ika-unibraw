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

            <div class="flex items-center mt-6 space-x-5">
                <x-filament::button size="lg" @style([
                    'background-color:'. $color
                ]) type="submit" wire:target="submit">
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
