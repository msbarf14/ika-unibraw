<div id="greeting" {{ $attributes->merge(['class' => 'bg-[#F5F5F5]']) }}>
    <div class="grid max-w-6xl grid-cols-12 gap-8 mx-auto">
        <div class="col-span-6 col-start-4 md:col-start-2 md:col-span-3">
            <div class="bg-gray-100 rounded-lg">
                <img src="{{ $greet['photo'] }}" alt="{{ $greet['name'] }}" class="w-full drop-shadow-lg">
            </div>
        </div>
        <div class="col-span-10 col-start-2 md:col-span-6 md:col-start-6">
            <div class="text-2xl font-bold md:text-4xl">
                {{ $greet['message'] }}
            </div>
            <a href="https://varianiaga.com/direktur-utama" class="hover:text-gray-600">
                <div class="mt-8 text-xl font-bold">
                    {{ $greet['name'] }}
                </div>
            </a>
            <div class="max-w-xs text-lg">{{ $greet['occupation'] }}</div>
        </div>
    </div>
</div>