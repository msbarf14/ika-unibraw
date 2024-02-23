<div>
    {{-- Navigation --}}
    <div
        x-data="{
            mobileNav: false,
        }"
        class="relative bg-brand-primary"
    >
        <div class="flex items-center justify-between px-4 py-6 mx-auto max-w-7xl sm:px-6 md:space-x-10">

            {{-- Logo --}}
            <div>
                <a href="/" class="flex text-black">
                    <div class="flex items-center space-x-2">
                        <img src="{{asset('logo_ika_brawijaya.png')}}" alt="" class="w-auto h-20 sm:h-18 lg:inline">
                        <span class="font-bold text-white">IKATAN ALUMNI <br> UNIVERSITAS BRAWIJAYA</span>
                    </div>
                </a>
            </div>

            {{-- Mobile Nav Icon --}}
            <div class="-my-2 -mr-2 md:hidden">
                <button
                    x-on:click="mobileNav = true"
                    class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-full hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-blue"
                >
                    <span class="sr-only">Open menu</span>
                    <x-filament::icon
                        icon="heroicon-o-bars-3"
                        class="w-6 h-6"
                    />
                </button>
            </div>

            {{-- Main Navigation --}}
            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                <nav class="flex space-x-10">
                    @foreach ($navigations as $index => $navigation)
                        @if (count($navigation['childs']))
                            <div
                                x-data="{
                                    open: false,
                                    toggle() {
                                        if (this.open) {
                                            return this.close()
                                        }

                                        this.$refs.button.focus()

                                        this.open = true
                                    },
                                    close(focusAfter) {
                                        if (! this.open) return

                                        this.open = false

                                        focusAfter && focusAfter.focus()
                                    }
                                }"
                                x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                x-id="['dropdown-button']"
                                class="relative"
                            >
                                {{-- Button --}}
                                <button
                                    x-ref="button"
                                    x-on:click="toggle()"
                                    :aria-expanded="open"
                                    :aria-controls="$id('dropdown-button')"
                                    type="button"
                                    class="inline-flex items-center text-base text-white rounded-md group hover:text-brand-blue focus:outline-none"
                                    x-bind:class="open? 'text-brand-blue' : 'text-black'"
                                    @mouseover="() => {
                                        responsiveVoice.cancel();
                                        responsiveVoice.speak('{{ e($navigation['name']) }}', 'Indonesian Female');
                                    }"
                                >
                                    <span>{{ $navigation['name'] }}</span>
                                    <x-filament::icon
                                        icon="heroicon-o-chevron-down"
                                        class="w-4 h-4 ml-2 group-hover:text-brand-blue/80"
                                        x-bind:class="open? 'text-brand-blue' : 'text-white'"
                                    />
                                </button>

                                {{-- Panel --}}
                                <div
                                    x-ref="panel"
                                    x-show="open"
                                    x-transition:enter="transition duration-200 ease-out"
                                    x-transition:enter-start="translate-y-1 opacity-0"
                                    x-transition:enter-end="translate-y-0 opacity-100"
                                    x-transition:leave="transition duration-150 ease-in"
                                    x-transition:leave-start="translate-y-0 opacity-100"
                                    x-transition:leave-end="translate-y-1 opacity-0"
                                    x-on:click.outside="close($refs.button)"
                                    :id="$id('dropdown-button')"
                                    style="display: none;"
                                    class="absolute z-10 max-w-lg mt-3 transform -translate-x-1/2 left-1/2"
                                >
                                    {{-- Arrow up --}}
                                    <div class="mx-auto border-x-transparent border-t-transparent border-b-brand-blue" style="border-width: 8px; border-style: solid; width: 0;"></div>

                                    <div class="py-6 min-w-[250px] max-w-md overflow-hidden text-white shadow-lg bg-brand-blue rounded-lg ring-1 ring-black ring-opacity-5">
                                        @foreach ($navigation['childs'] as $subNavigation)
                                            <a
                                                href="{{ $subNavigation['url'] }}"
                                                class="block px-6 py-2 hover:bg-white/10"
                                            >
                                                {{ $subNavigation['name'] }}
                                            </a>
                                            @if(count($subNavigation['childs']))
                                            <div class="px-6 pb-2">
                                                @foreach ($subNavigation['childs'] as $subNavigationNested)
                                                    <a
                                                        href="{{ $subNavigationNested['url'] }}"
                                                        class="block px-3 py-1 text-sm border-b border-l border-dotted border-white/30 hover:bg-white/10"
                                                    >
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
                        <a
                            href="{{ $navigation['url'] }}"
                            class="text-base text-white hover:text-brand-blue"
                        >
                            {{ $navigation['name'] }}
                        </a>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Mobile Nav List --}}
        <x-shared.navigation.mobile :navigations="$navigations" />
    </div>
</div>
