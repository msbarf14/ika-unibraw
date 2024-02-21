<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <x-shared.decoration />

        {{-- Main Content --}}
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mx-auto text-lg max-w-prose">
                <h1>
                    <span class="block text-base font-semibold tracking-wide text-center uppercase text-brand-blue">{{ implode(', ', $post->tags) }}</span>
                    <span
                        class="block mt-2 text-3xl font-extrabold leading-8 tracking-tight text-center text-gray-900 sm:text-4xl"
                        >{{ $post->title }}</span
                    >
                </h1>

                @if ($post->img_url)
                    <div class="mt-8 aspect-video rounded-lg shadow overflow-hidden">
                        <img src="{{ $post->img_url }}" alt="{{ $post->title }}" class="object-cover w-full h-full">
                    </div>
                @endif
                <div class="flex flex-wrap justify-between text-sm">
                    <div class="flex items-center text-gray-400 {{ $post->img_url? 'mt-3' : 'mt-8' }}">
                        <x-filament::icon
                            icon="heroicon-o-calendar-days"
                            class="w-5 h-5 mr-2"
                        />
                        <time datetime="{{ $post->published_at }}">{{ $post->published_at?->isoFormat('dddd, DD MMMM Y H:mm z') }}</time>
                    </div>
                    <div class="flex items-center text-gray-400 {{ $post->img_url? 'mt-3' : 'mt-8' }}">
                        <x-filament::icon
                            icon="carbon-user"
                            class="w-5 h-5 mr-2"
                        />
                        <span>{{ $post->author?->name }}</span>
                    </div>
                </div>
            </div>
            <div class="mx-auto mt-8 prose prose-lg text-gray-500 prose-indigo">
                {!! $post->content !!}
            </div>
        </div>
    </div>
    <x-shared.footer />
</div>
