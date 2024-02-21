@props([
    'unit',
    'inverse'
])

<div {{ $attributes->merge(['class' => 'grid max-w-6xl grid-cols-1 gap-6 mx-auto md:grid-cols-2']) }}>
    <div>
        <div class="aspect-auto bg-[#EAEAEA] rounded-2xl overflow-hidden">
            <img src="{{ $unit['image'] }}" alt="{{ $unit['name'] }}" class="object-cover w-full h-full" />
        </div>
    </div>

    <div 
        @class([
            'flex flex-col justify-center',
            'md:order-first' => $inverse
        ])
    >
        <div 
            @class([
                'max-w-md',
                'ml-auto' => !$inverse,
                'mr-auto' => $inverse
            ])
        >
            <h4 class="text-2xl font-bold md:text-3xl">{{ $unit['name'] }}</h4>

            <div class="mt-8 overflow-hidden prose prose-lg text-black line-clamp-6">
                {!! $unit['description'] !!}
            </div>

            <div class="mt-8">
                <a 
                    href="{{ $unit['link'] }}" 
                    class="inline-flex items-center px-4 py-3 border text-lg border-gray-300 leading-4 rounded-md text-black bg-white hover:bg-gray-50 hover:text-brand-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue"
                >
                    Selengkapnya
                    <x-filament::icon
                        icon="heroicon-o-arrow-small-right"
                        class="w-5 h-5 ml-3 -mr-1"
                    />
                </a>
            </div>
        </div>
    </div>
</div>