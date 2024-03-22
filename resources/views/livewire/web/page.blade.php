<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <x-shared.decoration />

        {{-- Main Content --}}
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mx-auto text-lg max-w-prose">
                <h1>
                    <span class="block mt-2 text-3xl font-extrabold leading-8 tracking-tight text-center text-gray-900 sm:text-4xl">
                        {{ $page->title }}
                    </span>
                </h1>

                @if ($page->img_url)
                    <div class="mt-8 overflow-hidden">
                        <img src="{{ $page->img_url }}" alt="{{ $page->title }}" class="w-full h-auto">
                    </div>
                @endif
            </div>
            <div class="mx-auto mt-6 prose prose-lg prose-p:text-justify leading-relaxed text-gray-500 prose-indigo">
                {!! $page->content !!}
            </div>

            @if (count($page->documents))
                <div class="mx-auto mt-6 prose prose-lg">
                    <div class="font-bold">Dokumen: </div>
                    <ul>
                        @foreach ($page->documents as $document)
                            <li>
                                <a href="{{ $document->getUrl() }}" target="_blank" class="hover:text-gray-500">
                                    {{  sprintf('%s.%s', $document->name, $document->extension) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <x-shared.footer />
</div>
