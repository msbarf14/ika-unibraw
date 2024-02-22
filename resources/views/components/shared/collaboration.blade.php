<div class="bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-10 lg:px-0 relative z-10">
        <div class="bg-gray-100 border-x-2 rounded-t-xl border-brand-primary/70 py-10 px-10 grid grid-cols-1 lg:grid-cols-2">
            <div class="w-full">
                <div class="flex justify-center">
                    <div class="border-b-4 border-brand-primary w-1/4 pb-2">
                        <h3 class="text-center text-2xl font-semibold">Kerjasama</h3>
                    </div>
                </div>
                <div class="pt-6 space-y-6">
                    @foreach ($collaboration as $item)
                        <div>
                            <div class="flex items-center text-gray-400">
                                <x-filament::icon
                                    icon="heroicon-o-calendar-days"
                                    class="w-5 h-5 mr-2"
                                />
                                <time>{{ $item['published_at']->isoFormat('dddd, DD MMMM Y') }}</time>
                            </div>
                            <a href="{{ route('post', $item['slug']) }}"
                                class="text-lg font-semibold hover:text-brand-primary hover:underline">{{$item['title']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full">
                <div class="flex justify-center">
                    <div class="border-b-4 border-brand-primary w-1/4 pb-2">
                        <h3 class="text-center text-2xl font-semibold">Karir</h3>
                    </div>
                </div>
                <div class="pt-6 space-y-6">
                    @foreach ($careers as $item)
                        <div>
                            <div class="flex items-center text-gray-400">
                                <x-filament::icon
                                    icon="heroicon-o-calendar-days"
                                    class="w-5 h-5 mr-2"
                                />
                                <time>{{ $item['published_at']->isoFormat('dddd, DD MMMM Y') }}</time>
                            </div>
                            <a href="{{ route('post', $item['slug']) }}"
                                class="text-lg font-semibold hover:text-brand-primary hover:underline">{{$item['title']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <x-shared.decoration/>

</div>
