@props([
    'navigations'
])
<div 
    x-cloak
    x-show="mobileNav"
    x-transition:enter="transition duration-200 ease-out"
    x-transition:enter-start="scale-95 opacity-0"
    x-transition:enter-end="scale-100 opacity-100"
    x-transition:leave="transition duration-100 ease-in"
    x-transition:leave-start="scale-100 opacity-100"
    x-transition:leave-end="scale-95 opacity-0"
    class="absolute inset-x-0 top-0 z-10 p-2 transition origin-top-right transform lg:hidden"
    x-on:click.outside="mobileNav = false"
>
    <div class="bg-white divide-y-2 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 divide-gray-50">
        <div class="px-5 pt-5 pb-6">

            {{-- Logo and close button --}}
            <div class="flex items-center justify-between">
                <a href="/">
                    {{-- <x-shared.logo class="w-auto h-8" /> --}}
                    <span class="font-bold">IKATAN ALUMNI <br> UNIVERSITAS BRAWIJAYA</span>
                    <p class="text-sm">Kalimantan Timur</p>
                </a>
                <div class="-mr-2">
                    <button
                        x-on:click="mobileNav = false"
                        class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-full hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-blue"
                    >
                        <span class="sr-only">Close menu</span>
                        <x-filament::icon
                            icon="heroicon-o-x-mark"
                            class="w-6 h-6"
                        />
                    </button>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="mt-6">
                <nav class="grid gap-6">
                    @foreach ($navigations as $navigation)
                        <a
                            href="{{ $navigation['url'] }}"
                            class="flex items-center p-3 -m-3 rounded-lg"
                        >
                            <div class="ml-4 text-base font-medium text-gray-900">
                                {{ $navigation['name'] }}
                            </div>
                        </a>

                        {{-- Navigation child --}}
                        @foreach ($navigation['childs'] as $subNavigation)
                            <a
                                href="/{{ $subNavigation['url'] }}"
                                class="flex items-center px-3 py-2 -m-3 rounded-lg hover:bg-gray-50"
                            >
                                <div class="ml-10 text-base text-gray-900">
                                    {{ $subNavigation['name'] }}
                                </div>
                            </a>
                        @endforeach
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</div>