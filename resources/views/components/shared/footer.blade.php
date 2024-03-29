<div class="px-4 sm:px-6 bg-[#00142F]">
    <div class="flex flex-wrap items-center justify-between max-w-6xl py-8 mx-auto">
        <div class="text-white py-2 text-center lg:text-left w-full lg:w-auto">
            <div class="text-base">
                &copy; 2024 All Rights Reserved.
            </div>
            <div class="text-base">
                <p>Ikatan Alumni Universitas Brawijaya.</p>
                <p class="text-xs opacity-50">Pengurus Daerah Kalimantan Timur.</p>
            </div>
        </div>
        <div class="flex justify-center flex-1 py-5 space-x-8 md:flex-none text-white">
            @foreach ($social_media as $key => $medsos)
                @php
                    $icon = match ($key) {
                        'facebook' => 'si-facebook',
                        'instagram' => 'si-instagram',
                        'twitter' => 'carbon-logo-x',
                        'youtube' => 'si-youtube',
                        'tiktok' => 'si-tiktok',
                        'email' => null,
                        'whatsapp' => null,
                    };
                @endphp

                @if ($medsos)
                    @if ($icon != null)
                        <a href="{{ $medsos }}" class="hover:text-white" target="_blank">
                            <x-filament::icon icon="{{ $icon }}" class="w-6 h-6 md:w-5 md:h-5" />
                        </a>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
