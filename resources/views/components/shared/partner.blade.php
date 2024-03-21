<div {{ $attributes->merge(['class' => '']) }}>
    <div class="bg-white py-10" style="background-image: url('/assets/dayak_pattern.svg');background-size: contain;">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto mt-10 grid max-w-lg grid-cols-1 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-1 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                @foreach ($partners as $partner)
                    <div>
                        <img class="col-span-2 aspect-square mx-auto max-h-32 w-full object-contain lg:col-span-1"
                            src="{{ $partner['logo'] }}" alt="Transistor">
                        <p class="mt-4 font-bold text-gray-600 text-center">{{ $partner['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
