<div>
    {{-- Navigation --}}

    <div x-data="{
        mobileNav: false,
    }" class="relative bg-white bg-opacity-10 border-b border-gray-200"
        style="background-image: url('/assets/dayak_pattern.svg');background-size: contain;">

        <div class=" w-full bg-brand-primary py-7 px-6 flex justify-end space-x-3">
            <livewire:components.search />
            <a href="#"
                class="flex relative z-30 space-x-2 py-2 px-4 rounded-lg hover:bg-green-500 bg-emerald-500 text-white shadow-lg">
                <span>Donasi</span>
                <x-filament::icon icon="heroicon-o-envelope-open" class="w-6 h-6" />
            </a>
        </div>
        <div class="hidden xl:block absolute w-full  z-20 -top-0">
            <div class="flex justify-center">
                <div
                    class="h-[10rem] w-[10rem] bg-zinc-100 border border-gray-200 grid place-items-center rounded-b-2xl">
                    <a href="/">
                        <img src="{{ asset('logo_ika_brawijaya.png') }}" alt="" class="w-full h-auto">
                    </a>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between px-4 py-4 mx-auto sm:px-6 md:space-x-10 md:px-16 7xl:px-24">

            {{-- Logo --}}
            <div class="relative z-30">
                <a href="/" class="flex text-black">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('logo_ika_brawijaya.png') }}" class="w-20 h-20 xl:hidden">
                        <div class="leading-5">
                            <p class="text-sm">IKATAN ALUMNI</p>
                            <p class="font-bold "> UNIVERSITAS BRAWIJAYA</p>
                            <p class="text-sm">Kalimantan Timur</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Main Navigation --}}
            <div class="relative z-30 hidden lg:flex-1 lg:flex lg:items-center lg:justify-end">
                <nav class="flex items-center space-x-4">
                    @foreach ($navigations as $index => $navigation)
                        @if (count($navigation['childs']))
                            <div x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }
                            
                                    this.$refs.button.focus()
                            
                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (!this.open) return
                            
                                    this.open = false
                            
                                    focusAfter && focusAfter.focus()
                                }
                            }"
                                x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                x-id="['dropdown-button']" class="relative">
                                {{-- Button --}}
                                <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                                    :aria-controls="$id('dropdown-button')" type="button"
                                    class="inline-flex items-center text-base text-black rounded-md group hover:text-brand-blue focus:outline-none"
                                    x-bind:class="open ? 'text-brand-blue' : 'text-black'">
                                    <span>{{ $navigation['name'] }}</span>
                                    <x-filament::icon icon="heroicon-o-chevron-down"
                                        class="w-4 h-4 ml-2 group-hover:text-brand-blue/80"
                                        x-bind:class="open ? 'text-brand-blue' : 'text-black'" />
                                </button>

                                {{-- Panel --}}
                                <div x-ref="panel" x-show="open" x-transition:enter="transition duration-200 ease-out"
                                    x-transition:enter-start="translate-y-1 opacity-0"
                                    x-transition:enter-end="translate-y-0 opacity-100"
                                    x-transition:leave="transition duration-150 ease-in"
                                    x-transition:leave-start="translate-y-0 opacity-100"
                                    x-transition:leave-end="translate-y-1 opacity-0"
                                    x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')"
                                    style="display: none;"
                                    class="absolute z-10 max-w-lg mt-3 transform -translate-x-1/2 left-1/2">
                                    {{-- Arrow up --}}
                                    <div class="mx-auto border-x-transparent border-t-transparent border-b-brand-blue"
                                        style="border-width: 8px; border-style: solid; width: 0;"></div>

                                    <div
                                        class="py-6 min-w-[250px] max-w-md overflow-hidden text-white  shadow-lg bg-brand-blue rounded-lg ring-1 ring-black ring-opacity-5">
                                        @foreach ($navigation['childs'] as $subNavigation)
                                            <a href="{{ $subNavigation['url'] }}"
                                                class="block px-6 py-2 hover:bg-white/10">
                                                {{ $subNavigation['name'] }}
                                            </a>
                                            @if (count($subNavigation['childs']))
                                                <div class="px-6 pb-2">
                                                    @foreach ($subNavigation['childs'] as $subNavigationNested)
                                                        <a href="{{ $subNavigationNested['url'] }}"
                                                            class="block px-3 py-1 text-sm border-b border-l border-dotted border-white/30 hover:bg-white/10">
                                                            {{ $subNavigationNested['name'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ $navigation['url'] }}" class="text-base text-black hover:text-brand-blue">
                                {{ $navigation['name'] }}
                            </a>
                        @endif
                    @endforeach

                </nav>
            </div>

            {{-- Mobile Nav Icon --}}
            <div class="-my-2 -mr-2 lg:hidden">
                <button x-on:click="mobileNav = true"
                    class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-full hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-blue">
                    <span class="sr-only">Open menu</span>
                    <x-filament::icon icon="heroicon-o-bars-3" class="w-6 h-6" />
                </button>
            </div>


        </div>

        {{-- Mobile Nav List --}}
        <x-shared.navigation.mobile :navigations="$navigations" />
    </div>
</div>
