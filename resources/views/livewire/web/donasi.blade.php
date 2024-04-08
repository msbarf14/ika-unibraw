<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mx-auto text-lg max-w-prose">
                <h1>
                    <span
                        class="block mt-2 text-3xl font-extrabold leading-8 tracking-tight text-center text-gray-900 sm:text-4xl"
                        >Donasi</span
                    >
                </h1>
            </div>
            <div class="grid max-w-6xl grid-cols-12 gap-8 mx-auto mt-24">
                @foreach ($campaigns as $item)
                    <div
                        class="col-span-12 md:col-span-4"
                    >
                        <div
                            class="overflow-hidden bg-gray-100 rounded-lg aspect-video"
                        >
                            <img
                                src="{{ asset($item['image']) }}"
                                alt="{{ $item['title'] }}"
                                class="object-cover w-full h-full"
                            />
                        </div>
                        <a href="#">
                            <div class="mt-4 text-lg font-bold hover:text-gray-600">
                                {{ $item['title'] }}
                            </div>
                        </a>
                        @if ($item['display_amount'])
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-sm text-gray-500">Target</p>
                                <p class="text-sm text-gray-500">{{ number_format($item['amount'])}}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Terkumpul</p>
                                <p class="text-sm text-gray-500">{{ number_format($item['amount'])}}</p>
                            </div>
                        @endif
                        <a href="{{route('donasi.detail', ['campaign' => $item['id']])}}" class="flex mt-4 justify-center w-full bg-gray-50 border border-gray-400 text-center py-3 rounded-lg">Donasi</a>
                    </div>
                @endforeach
                <div class="col-span-12 mt-8 text-center">
                    {{ $campaigns->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-shared.footer />
</div>
