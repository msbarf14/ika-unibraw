<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <x-shared.decoration />

        {{-- Main Content --}}
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mx-auto text-lg max-w-prose">
                <h1>
                    <span
                        class="block mt-2 text-3xl font-extrabold leading-8 tracking-tight text-center text-gray-900 sm:text-4xl"
                        >Vidio</span
                    >
                </h1>
            </div>

            <div class="grid max-w-6xl grid-cols-12 gap-8 mx-auto mt-24">
                @foreach ($videos as $item)
                    <div
                        class="col-span-12 md:col-span-4"
                    >
                        <div
                            class="overflow-hidden bg-gray-100 rounded-lg aspect-video"
                        >
                            <iframe  class="object-cover w-full h-full" src="{{$item['link']}}" title="{{$item['title']}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <div class="mt-4 text-2xl font-bold hover:text-gray-600">
                            {{ $item['title'] }}
                        </div>
                    </div>
                @endforeach

                <div class="col-span-12 mt-8 text-center">
                    {{ $videos->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-shared.footer />
</div>
