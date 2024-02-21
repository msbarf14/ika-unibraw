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
                    @foreach (range(0, 4) as $item)
                        <div>
                            <p class="text-gray-700">JANUARI 2024</p>
                            <a href="#"
                                class="text-lg font-semibold hover:text-brand-primary hover:underline">Lorem ipsum dolor
                                sit amet consectetur adipisicing elit.</a>
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
                    @foreach (range(0, 4) as $item)
                        <div>
                            <p class="text-gray-700">JANUARI 2024</p>
                            <a href="#"
                                class="text-lg font-semibold hover:text-brand-primary hover:underline">Lorem ipsum dolor
                                sit amet consectetur adipisicing elit.</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <x-shared.decoration/>

</div>
