<div>
    <div class="w-full " style="background-image: url('/assets/dayak_pattern.svg');background-size: contain;">
        <div class="mx-auto max-w-7xl px-10 lg:px-10 xl:px-0 py-4">
            <h3 class="text-3xl italic  text-brand-primary">Informasi</h3>
            <h3 class="text-4xl font-bold text-brand-primary">Konseling, Kerjasama, Karir</h3>
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-10 pb-20 lg:px-10 xl:px-0">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div>
                <div class="mt-6">
                    <h3 class="text-2xl italic  text-gray-400">Konseling</h3>
                </div>
                <div class="h-[50dvh] w-full mt-6 overflow-y-scroll space-y-6 pb-10">
                    @foreach ($konseling as $item)
                        <div class="sm:inline-block sm:w-full">
                            <figure class="rounded-2xl bg-gray-50 border p-8 text-sm leading-6">
                                <blockquote class="text-gray-900">
                                    <a href="{{route('post', ['post' => $item['slug']])}}" class="font-semibold hover:text-brand-secondary">{{$item['title']}}</a>
                                </blockquote>
                                <small>{{$item['date']}}</small>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mt-6">
                    <h3 class="text-2xl italic  text-gray-400">Kerjasama</h3>
                </div>
                <div class="h-[50dvh] w-full mt-6 overflow-y-scroll space-y-6 pb-10">
                    @foreach ($kerjasama as $item)
                        <div class="sm:inline-block sm:w-full">
                            <figure class="rounded-2xl bg-gray-50 border p-8 text-sm leading-6">
                                <blockquote class="text-gray-900">
                                    <a href="{{route('post', ['post' => $item['slug']])}}" class="font-semibold hover:text-brand-secondary">{{$item['title']}}</a>
                                </blockquote>
                                <small>{{$item['date']}}</small>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mt-6">
                    <h3 class="text-2xl italic  text-gray-400">Karir</h3>
                </div>
                <div class="h-[50dvh] w-full mt-6 overflow-y-scroll space-y-6 pb-10">
                    @foreach ($karir as $item)
                    <div class="sm:inline-block sm:w-full">
                        <figure class="rounded-2xl bg-gray-50 border p-8 text-sm leading-6">
                            <blockquote class="text-gray-900">
                                <a href="{{route('post', ['post' => $item['slug']])}}" class="font-semibold hover:text-brand-secondary">{{$item['title']}}</a>
                            </blockquote>
                            <small>{{$item['date']}}</small>
                        </figure>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
