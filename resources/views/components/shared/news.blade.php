<div {{ $attributes->merge(['class' => 'overflow-hidden px-10 sm:px-10']) }}>
    <div class="max-w-7xl mx-auto py-6">
        <h3 class="text-3xl italic font-bold text-brand-primary">Berita & Kegiatan</h3>
    </div>
    <div class="max-w-7xl mx-auto py-6">
        <div class="grid grid-cols-6 gap-10">
            <div class="col-span-6 lg:col-span-3">
                @foreach ($pin as $post)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <img src="{{ $post['image'] }}"
                                alt="{{$post['title']}}"
                                loading="lazy"
                                class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <time datetime={{ $post['published_at']->isoFormat('dddd, DD MMMM Y') }}" class="text-gray-500">{{ $post['published_at']->isoFormat('dddd, DD MMMM Y') }}</time>
                                {{-- <a href="#"
                                    class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a> --}}
                            </div>
                            <div class="group relative">
                                <h3
                                    class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="/news/{{$post['slug']}}">
                                        <span class="absolute inset-0"></span>
                                       {{$post['title']}}
                                    </a>
                                </h3>
                                <div class="line-clamp-3 mt-5 text-lg  leading-6 text-gray-600 prose prose-p:text-justify max-w-prose break-all">
                                    {!! $post['content'] !!}
                                </div>
                            </div>
                        </div>
                    </article>
                    <div class="pt-2 flex lg:justify-end"> 
                        <a href="/news/{{$post['slug']}}" class="text-blue-500">Selengkapnya...</a>
                    </div>
                @endforeach
            </div>
            <div class="col-span-6 lg:col-span-3 space-y-6 overflow-hidden">
                @foreach ($news as $post)
                    <article class="relative isolate flex flex-col gap-8 md:flex-row">
                        <div class="relative aspect-[16/9] sm:aspect-[2/1] md:aspect-[2/1] md:w-52 md:shrink-0">
                            <img src="{{$post['image']}}"
                                alt="{{$post['title']}}"
                                loading="lazy"
                                class="absolute inset-0 h-full w-full rounded-2xl bg-gray-50 object-cover">
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="w-full">
                            <div class="flex items-center gap-x-4 text-xs">
                                <time datetime={{ $post['published_at']->isoFormat('dddd, DD MMMM Y') }}" class="text-gray-500">{{ $post['published_at']->isoFormat('dddd, DD MMMM Y') }}</time>
                            </div>
                            <div class="group relative max-w-xl">
                                <h3
                                    class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="/news/{{$post['slug']}}">
                                        <span class="absolute inset-0"></span>
                                       {{$post['title']}}
                                    </a>
                                </h3>
                                <div class="line-clamp-3 mt-5 text-gray-500 prose prose-p:text-justify ">
                                    {!! $post['content'] !!}
                                </div>
                            </div>
                        </div>
                    </article>
                    <div class="pt-0 flex lg:justify-end"> 
                        <a href="/news/{{$post['slug']}}" class="text-blue-500">Selengkapnya...</a>
                    </div>
                @endforeach
                <div class=" mt-8 ">
                    <a href="{{ route('news') }}"
                        class="inline-flex items-center px-4 py-3 border text-lg border-gray-300 leading-4 rounded-md text-black bg-white hover:bg-gray-50 hover:text-brand-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        Berita Lainnya
                        <x-filament::icon icon="heroicon-o-arrow-small-right" class="w-5 h-5 ml-3 -mr-1" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
