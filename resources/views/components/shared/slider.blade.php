@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush

<div x-data="{
    swiper: null
}" x-init="$nextTick(() => {
    swiper = new Swiper($refs.container, {
        loop: true,
        navigation: {
            nextEl: $refs.next,
            prevEl: $refs.prev,
        },
        pagination: {
            el: $refs.pagination,
            clickable: true,
        },
        autoplay: {
            delay: 5000,
        }
    });
})">
    <!-- Slider main container -->
    <div class="swiper" x-ref="container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($sliders as $slider)
                <div class="swiper-slide relative overflow-hidden">
                    <img class="object-cover lg:object-cover w-full h-[20rem] lg:h-[30rem] "
                        src="{{ $slider['background'] }}" alt="{{ $slider['title'] }}" />
                    <div
                        class="hidden lg:block absolute inset-0 bg-gradient-to-r from-brand-secondary/90 via-brand-secondary/70 to-brand-secondary/50 md:to-brand-secondary/20 ">
                        &nbsp;</div>
                    <div class="hidden lg:block absolute inset-0 z-10">
                        <div class="w-full h-full pl-24 lg:pl-24 2xl:pl-[18rem]">
                            <div class="max-w-3xl pl-24 h-full flex flex-col justify-center items-start">
                                <div class="text-lg lg:text-3xl italic text-white leading-8 ">
                                    {{ $slider['title'] }}
                                </div>
                                <div class="text-2xl lg:text-4xl text-white font-bold leading-7">
                                    {{ $slider['description'] }}
                                </div>
                                <div class="mt-4 md:mt-8">
                                    @php
                                        $external = $slider['type'] === 'external';
                                    @endphp

                                    <a href="{{ $slider['link'] }}" target="{{ $external ? '_blank' : '_self' }}"
                                      class="inline-flex bg-brand-primary text-white items-center px-3 py-1.5 md:px-4 md:py-2 text-sm md:text-lg md:font-medium  border border-transparent rounded shadow-sm hover:shadow-2xl">
                                        <span>Selengkapnya</span>
                                        <x-filament::icon icon="heroicon-o-arrow-small-right"
                                            class="w-5 h-5 ml-3 -mr-1" />
                                    </a>
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
