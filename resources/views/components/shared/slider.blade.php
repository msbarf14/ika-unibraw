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
                    <img class="object-cover w-full h-[50rem] " src="{{ $slider['background'] }}"
                        alt="{{ $slider['title'] }}" />
                    <div class="absolute inset-0 bg-gradient-to-r from-sky-500">&nbsp;</div>
                    <div class="absolute inset-0 z-10">
                        <div class="w-full h-full ">
                            <div class="max-w-7xl pl-36 h-full  flex flex-col justify-center">
                                <div
                                    class="text-xl text-white leading-5 md:text-2xl font-bold md:leading-tight lg:text-4xl line-clamp-3 backdrop-blur-sm md:backdrop-blur-none">
                                    {{ $slider['title'] }}
                                </div>
                                <div
                                class="text-xl text-white leading-5 md:text-2xl font-bold md:leading-tight lg:text-4xl line-clamp-3 backdrop-blur-sm md:backdrop-blur-none">
                                {{ $slider['description'] }}
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
