<div {{ $attributes->merge(['class' => '']) }}>
    <div class="bg-white py-10" style="background-image: url('/assets/dayak_pattern.svg');background-size: contain;">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                {{-- @foreach ($partners as $partner)
                    @if ($partner['logo'])
                        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"
                            src="{{ $partner['logo'] }}" alt="Transistor"
                            width="158" height="48">
                    @else
                        <div class="col-span-2 max-h-12 w-full object-contain lg:col-span-1">
                            <h1 class="text-2xl"> {{ $partner['name'] }}</h1>
                        </div>
                    @endif
                @endforeach --}}
            </div>
        </div>
    </div>
</div>
