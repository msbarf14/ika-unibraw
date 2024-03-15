<div>
    <div class="relative min-h-[40dvh]"
        style="background-image: url('https://images.unsplash.com/photo-1477281765962-ef34e8bb0967?q=80&w=3733&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');background-size: cover;background-position: bottom;">
        <div class="absolute bg-gradient-to-l from-brand-secondary to-brand-secondary/90 h-full w-full "></div>
        <div class="relative z-10 min-h-[40dvh] max-w-7xl px-10 mx-auto py-10 grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="text-white h-full  flex flex-col justify-center">
                <h3 class="text-lg lg:text-2xl xl:text-3xl italic">Tentang</h3>
                <h1 class="text-2xl lg:text-4xl xl:text-5xl font-bold">IKATAN ALUMNI</h1>
                <h1 class="text-2xl lg:text-4xl xl:text-5xl font-bold">UNIV. BRAWIJAYA</h1>
                <h3 class=" text-lg lg:text-2xl xl:text-3xl">Kalimantan Timur</h3>
            </div>
            <div class="h-full  flex flex-col justify-center">
                <div class="text-white text-lg lg:text-lg xl:text-xl leading-relaxed space-y-4">
                    <p>
                        In a groundbreaking development, a team of scientists has successfully engineered a novel
                        nanomaterial capable of purifying contaminated water with unprecedented efficiency. This
                        innovative
                        technology, inspired by natural biological processes, utilizes a combination of nanotubes and
                        biomimetic structures to filter out pollutants, heavy metals, and pathogens at a molecular
                        level.
                    </p>
                    <p>Not only does this advance offer a sustainable solution to address water scarcity and pollution
                        challenges, but it also holds immense promise for communities worldwide grappling with access to
                        clean and safe drinking water. With further research and refinement, this nanomaterial could
                        revolutionize water treatment systems, providing a lifeline to millions and heralding a new era
                        of
                        environmental stewardship.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="relative bg-brand-primary">
        <div class="max-w-7xl mx-auto py-10">
            <div class="flex justify-between">
                <div class="text-white">
                    <div class="flex space-x-4 items-center w-[20rem]">
                        <x-filament::icon icon="heroicon-o-cursor-arrow-ripple" class="w-24 h-24" />
                        <div>
                            <h1 class="font-bold text-2xl">KONSELING</h1>
                            <p>Hukum, Teknik, Psikolog, Pertanian, Kesehatan, dll</p>
                        </div>
                    </div>
                </div>
                <div class="text-white">
                    <div class="flex space-x-4 items-center w-[20rem]">
                        <x-filament::icon icon="heroicon-o-trophy" class="w-24 h-24" />
                        <div>
                            <h1 class="font-bold text-2xl">KERJASAMA</h1>
                            <p>Peluang Kerjasama, dan Partner
                                Bersama IKA UB</p>
                        </div>
                    </div>
                </div>
                <div class="text-white">
                    <div class="flex space-x-4 items-center w-[20rem]">
                        <x-filament::icon icon="heroicon-o-users" class="w-24 h-24" />
                        <div>
                            <h1 class="font-bold text-2xl">KARIR</h1>
                            <p>Lowongan Kerja, Magang,
                                PKL, dan Beasiswa</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-6 lg:px-0">
        <div class="mx-auto mt-6 mb-16 flow-root max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none">
            <div class="mb-6">
                <h3 class="text-3xl italic  text-brand-primary">Informasi</h3>
                <h3 class="text-4xl font-bold text-brand-primary">Konseling, Kerjasama, Karir</h3>
            </div>
            <div class="-mt-8 sm:-mx-4 sm:columns-2 sm:text-[0] lg:columns-3">
                @for ($i = 0; $i < 9; $i++)
                    <div class="pt-8 sm:inline-block sm:w-full sm:px-4">
                        <figure class="rounded-2xl bg-gray-50 p-8 text-sm leading-6">
                            <blockquote class="text-gray-900">
                                <p>“Laborum quis quam. Dolorum et ut quod quia. Voluptas numquam delectus nihil. Aut
                                    enim doloremque et ipsam.”</p>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center gap-x-4">
                                <img class="h-10 w-10 rounded-full bg-gray-50"
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                                <div>
                                    <div class="font-semibold text-gray-900">Leslie Alexander</div>
                                    <div class="text-gray-600">@lesliealexander</div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
