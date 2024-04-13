<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <div class="relative px-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-6">
                <div class="col-span-3">
                    <img src="{{sprintf('/storage/%s', $donasi['image']) }}" alt="{{$donasi['title']}}" loading="lazy" class="aspect-video rounded-xl object-cover">
                    <h1 class="text-xl md:text-2xl mt-6">{{$donasi['title']}}</h1>
                    @if ($donasi['display_amount'])
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-lg text-gray-500">Target</p>
                            <p class="text-lg text-gray-500">{{ number_format($donasi['amount'])}}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-lg text-gray-500">Terkumpul</p>
                            <p class="text-lg text-green-700 font-medium">{{ number_format($total_amount)}}</p>
                        </div>
                    @endif
                    <div class="mt-6">
                        {{$donasi['description']}}
                    </div>
                    <div class="mt-10 hidden lg:block">
                        <p class="italic text-gray-600">Ucapan dan do'a</p>
                        <div class="border py-6 px-4 rounded-lg divide-y divide-dashed">
                            @foreach ($details as $item)
                                <div class="py-2">
                                    <h1 class="font-semibold text-gray-600">{{$item['name']}}</h1>
                                    <p>Berdonasi sebesar <b>Rp. {{number_format($item['amount'])}}</b></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class=" col-span-3 ">
                    <div class="bg-brand-primary text-white py-8 px-10 rounded-lg">
                        <div class="">
                            <div>
                                <img src="{{asset('assets/bank_logo/mandiri.png')}}" alt="" class="w-[10rem]">
                            </div>
                            <div class="pt-8 flex space-x-3 items-center">
                                <h1 id="account-number" class="text-xl md:text-2xl font-bold">1490024092027</h1>
                                <button class="p-2  bg-brand-secondary/30 focus:bg-blue-500 hover:bg-blue-500 rounded" 
                                    onclick="copyToClipboard()"> 
                                    <x-filament::icon
                                        icon="carbon-copy"
                                        class="w-5 h-5"
                                    />
                                </button>
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
                            'flex space-x-4 items-center mt-6 px-4 py-2 font-medium text-white border border-transparent rounded shadow-sm',
                            'focus:outline-none focus:ring-2 focus:ring-offset-2',
                            'bg-brand-blue hover:bg-brand-blue/80 focus:ring-brand-blue disabled:cursor-not-allowed',
                        ]) wire:loading.class="opacity-50">
                                <span>Submit</span>
                                <div wire:loading>
                                    <x-filament::icon
                                        icon="heroicon-o-arrow-path"
                                        class="w-5 h-5 animate-spin"
                                    />
                                </div>
                           </button>
                       </form>
                    </div>
                   <x-filament-actions::modals />
                    <div class="mt-10 block lg:hidden">
                        <p class="italic text-gray-600">Ucapan dan do'a</p>
                        <div class="border py-6 px-4 rounded-lg divide-y divide-dashed">
                            @foreach ($details as $item)
                                <div class="py-2">
                                    <h1 class="font-semibold text-gray-600">{{$item['name']}}</h1>
                                    <p>Berdonasi sebesar <b>Rp. {{number_format($item['amount'])}}</b></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
     function copyToClipboard() {
        var h1Element = document.getElementById('account-number');
        
        // Get its text content
        var textToCopy = h1Element.textContent;
        
        // Create a temporary textarea element to copy the text
        var textarea = document.createElement('textarea');
        textarea.value = textToCopy;
        document.body.appendChild(textarea);
        
        // Select the text in the textarea
        textarea.select();
        
        // Copy the selected text
        document.execCommand('copy');
        
        // Remove the temporary textarea
        document.body.removeChild(textarea);
        
        // Provide user feedback
        alert('Text copied to clipboard: ' + textToCopy);
    }
</script>
