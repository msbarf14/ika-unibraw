<div>
    <div class="w-full " style="background-image: url('/assets/dayak_pattern.svg');background-size: contain;">
        <div class="mx-auto max-w-7xl px-10 lg:px-10 xl:px-0 py-4">
            <h3 class="text-3xl italic  text-brand-primary">Sambutan</h3>
            <h3 class="text-4xl font-bold text-brand-primary">Ketua & Penasehat</h3>
        </div>
    </div>
    <div class="mx-auto max-w-7xl py-10 px-10 xl:px-0">
        <div class="mx-auto grid grid-cols-1 lg:mx-0 lg:max-w-none lg:grid-cols-2">
            <div class="flex flex-col pb-10 sm:pb-16 lg:pb-0 lg:pr-8 xl:pr-20">
                <figure class="mt-10 flex flex-auto flex-col justify-start">
                    <figcaption class=" flex items-center gap-x-6">
                        <img class="h-28 w-28 rounded-full bg-gray-50"
                            src="{{$greet['photo-penasehat']}}"
                            alt="">
                        <div class="text-base">
                            <div class="font-semibold text-gray-900">{{$greet['name-penasehat']}}</div>
                            <div class="mt-1 text-gray-500">{{$greet['occupation-penasehat']}}</div>
                        </div>
                    </figcaption>
                    <blockquote class="mt-10 text-lg leading-8 text-gray-900">
                        <div class="prose prose-base prose-p:text-justify line-clamp-5">{!! $greet['message-penasehat'] !!}</div>
                    </blockquote>
                    <a href="/arahan-penasehat" class="mt-4">Selengkapnya</a>
                </figure>
            </div>
            <div
                class="flex flex-col border-t border-gray-900/10 pt-10 sm:pt-16 lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0 xl:pl-20">
                <figure class="mt-10 flex flex-auto flex-col justify-start">
                    <figcaption class="flex items-center gap-x-6">
                        <img class="h-28 w-28 rounded-full bg-gray-50"
                            src="{{$greet['photo-ketua']}}"
                            alt="">
                        <div class="text-base">
                            <div class="font-semibold text-gray-900">{{$greet['name-ketua']}}</div>
                            <div class="mt-1 text-gray-500">{{$greet['occupation-ketua']}}</div>
                        </div>
                    </figcaption>
                    <blockquote class="mt-10  text-lg leading-8 text-gray-900">
                        <div class="prose prose-base prose-p:text-justify line-clamp-5">{!! $greet['message-ketua'] !!}</div>
                    </blockquote>
                    <a href="/sambutan-ketua-ika-ub-kaltim" class="mt-4">Selengkapnya</a>
                </figure>
            </div>
        </div>
    </div>
</div>
