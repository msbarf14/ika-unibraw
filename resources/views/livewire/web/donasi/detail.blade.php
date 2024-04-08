<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <div class="relative px-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-6">
                <div class="col-span-3">
                    <img src="{{asset($donasi['image'])}}" alt="{{$donasi['title']}}" loading="lazy" class="aspect-video rounded-xl object-cover">
                    <h1 class="text-xl md:text-2xl mt-6">{{$donasi['title']}}</h1>
                    @if ($donasi['display_amount'])
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-sm text-gray-500">Target</p>
                        <p class="text-sm text-gray-500">{{ number_format($donasi['amount'])}}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-500">Terkumpul</p>
                        <p class="text-sm text-gray-500">{{ number_format($donasi['amount'])}}</p>
                    </div>
                @endif
                <div class="mt-6">
                    {{$donasi['description']}}
                </div>
                </div>
                <div class="col-span-3">
                    <div class="bg-brand-primary text-white py-8 px-10 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <img src="{{asset('assets/bank_logo/mandiri.png')}}" alt="" class="w-[10rem]">
                            </div>
                            <div class="pt-8">
                                <h1 class="text-xl md:text-2xl font-bold">149 00 24092027</h1>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm mt-6 italic">Atas nama</p>
                            <p class="font-semibold">Perkumpulan Ikatan Alumni <br> Universitas Brawijaya Kalimantan Timur</p>
                        </div>
                    </div>
                    <div class="mt-6 border border-blue-500/30 px-6 py-4 rounded-lg bg-slate-50">
                        <form wire:submit="create">
                           {{ $this->form }}
                           <button type="submit" @class([
                            'inline-flex items-center mt-6 px-4 py-2 font-medium text-white border border-transparent rounded shadow-sm',
                            'focus:outline-none focus:ring-2 focus:ring-offset-2',
                            'bg-brand-blue hover:bg-brand-blue/80 focus:ring-brand-blue disabled:cursor-not-allowed',
                        ])>
                               Submit
                           </button>
                       </form>
                    </div>
                   <x-filament-actions::modals />
                </div>
            </div>
        </div> 
    </div>
</div>
