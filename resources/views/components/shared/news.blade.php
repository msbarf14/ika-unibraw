<div {{ $attributes->merge(['class' => 'px-4 sm:px-6']) }}>
    <div class="max-w-7xl mx-auto py-6">
        <h3 class="text-3xl font-bold text-brand-primary">Kabar Alumni</h3>
    </div>
    <div class="grid max-w-7xl grid-cols-12 gap-8 mx-auto mt-0">
        @foreach ($news as $post)
            <div class="col-span-12 md:col-span-4">
                <div class="overflow-hidden bg-gray-100 rounded-lg aspect-video">
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="object-cover w-full h-full" />
                </div>
                <div class="flex flex-wrap justify-between text-sm mt-4">
                    <div class="flex items-center text-gray-400">
                        <x-filament::icon
                            icon="heroicon-o-calendar-days"
                            class="w-5 h-5 mr-2"
                        />
                        <time>{{ $post['published_at']->isoFormat('dddd, DD MMMM Y') }}</time>
                    </div>
                </div>

                <a href="{{ route('post', $post['slug']) }}" >
                    <div class="mt-4 text-2xl font-bold line-clamp-2 hover:text-gray-600">{{ $post['title'] }}</div>
                </a>
            </div>
        @endforeach
        <div class="col-span-12 mt-8 text-center">
            <a 
                href="{{ route('news') }}" 
                class="inline-flex items-center px-4 py-3 border text-lg border-gray-300 leading-4 rounded-md text-black bg-white hover:bg-gray-50 hover:text-brand-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue"
            >
                Berita Lainnya
                <x-filament::icon
                    icon="heroicon-o-arrow-small-right"
                    class="w-5 h-5 ml-3 -mr-1"
                />
            </a>
        </div>
    </div>
</div>
