<div {{ $attributes->merge(['class' => '']) }}>
    <div class="max-w-6xl mx-auto">
        <h3 class="text-3xl font-bold text-center md:text-5xl text-[#1A4592]">B2B Trust</h3>
    </div>
    <div class="flex flex-wrap justify-center max-w-6xl mx-auto mt-24">
        @foreach ($partners as $partner)
            <div class="w-32 mx-8 overflow-hidden md:w-48 aspect-video">
                @if ($partner['logo'])
                    <img src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }}" class="object-contain object-center w-full h-full" />
                @else
                    <div class="flex items-center justify-center w-full h-full text-2xl font-bold text-center uppercase md:text-4xl">
                        {{ $partner['name'] }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>