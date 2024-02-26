@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush

<div
    x-data="{
        swiper: null
    }"
    x-init="$nextTick(() => {
        swiper = new Swiper($refs.container, {
            loop: true,
            navigation: {
                nextEl: $refs.next,
                prevEl: $refs.prev,
            },
            pagination: {
                el: $refs.pagination,
                clickable: true,
            }
        });
    })"
>
    <!-- Slider main container -->
    <div class="swiper" x-ref="container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($sliders as $slider)
            <div class="swiper-slide relative overflow-hidden">
                <img class="object-cover w-full h-[40rem] " src="{{ $slider['background'] }}" alt="{{ $slider['title'] }}" />
                <div class="absolute inset-0 bg-black/40">&nbsp;</div>
                <div class="absolute inset-0 z-10 flex items-center my-full text-white">
                    <div class="flex items-center justify-center max-w-xs px-4 mx-auto md:max-w-2xl lg:max-w-5xl sm:px-6">
                        {{-- <div class="w-1/2">
                            <div class="max-w-lg mx-auto">
                                <img src="{{ $slider['illustration'] }}" alt="{{ $slider['title'] }}" class="w-full" />
                            </div>
                        </div> --}}
                        <div class="lg:pl-4">
                            <div class="text-xl leading-5 md:text-2xl font-bold md:leading-tight lg:text-4xl line-clamp-3 backdrop-blur-sm md:backdrop-blur-none">{{ $slider['title'] }}</div>
                            <div class="text-[#F8F8F8] hidden md:block max-w-xs lg:max-w-md pr-5 text-lg mt-4">{{ $slider['description'] }}</div>
                            <div class="mt-4 md:mt-8">
                                @php
                                    $external = $slider['type'] === 'external';
                                @endphp
            
                                {{-- <a 
                                    href="{{ $slider['link'] }}" 
                                    target="{{ $external? '_blank' : '_self' }}"
                                    @class([
                                        'inline-flex items-center px-3 py-1.5 md:px-4 md:py-2 text-sm md:text-lg md:font-medium text-white border border-transparent rounded shadow-sm',
                                        'focus:outline-none focus:ring-2 focus:ring-offset-2',
                                        $slider['button_style']
                                    ])
                                >
                                    <span class="bg-[#49629B] hover:bg-[#49629B]/80 focus:ring-[#49629B] hidden"></span>
                                    Selengkapnya
                                    <x-filament::icon
                                        icon="heroicon-o-arrow-small-right"
                                        class="w-5 h-5 ml-3 -mr-1"
                                    />
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination" x-ref="pagination"></div>
    
        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev" x-ref="prev"></div>
        <div class="swiper-button-next" x-ref="next"></div>
    </div>
</div>