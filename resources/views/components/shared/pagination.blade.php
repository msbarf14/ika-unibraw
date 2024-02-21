@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md select-none">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md select-none">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between mt-6 -mx-1 -mb-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <x-shared.pagination.button disabled aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <x-filament::icon
                            icon="heroicon-o-chevron-left"
                            class="w-4 h-4"
                        />
                    </x-shared.pagination.button>
                @else
                    <x-shared.pagination.button 
                        wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                        dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" 
                        rel="prev"
                    >
                        <x-filament::icon
                            icon="heroicon-o-chevron-left"
                            class="w-4 h-4"
                        />
                    </x-shared.pagination.button>
                @endif

                {{-- Pagination Elements --}}
                <div>
                    @foreach ($elements as $element)
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <x-shared.pagination.button active aria-current="page">
                                        {{ $page }}
                                    </x-shared.pagination.button>
                                @else
                                    <x-shared.pagination.button
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" 
                                        wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    >
                                        {{ $page }}
                                    </x-shared.pagination.button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <x-shared.pagination.button 
                        wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                        dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" 
                        rel="next"
                    >
                        <x-filament::icon
                            icon="heroicon-o-chevron-right"
                            class="w-4 h-4"
                        />
                    </x-shared.pagination.button>
                @else
                    <x-shared.pagination.button disabled aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <x-filament::icon
                            icon="heroicon-o-chevron-right"
                            class="w-4 h-4"
                        />
                    </x-shared.pagination.button>
                @endif
            </div>
        </nav>
    @endif
</div>
