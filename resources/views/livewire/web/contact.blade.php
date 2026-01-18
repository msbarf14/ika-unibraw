<div class="px-4 text-white bg-brand-secondary py-28 sm:px-6" id="contact">
    <div class="grid max-w-6xl grid-cols-12 gap-8 mx-auto">
        <div class="col-span-12 text-lg lg:col-span-6">
            <div class="mt-8">
                <div class="max-w-lg">
                    <h1 class="text-2xl font-bold italic">Kontak </h1>

                    <div class="mt-10">
                        <h1 class="font-bold">IKATAN ALUMNI UNIVERSITAS BRAWIJAYA</h1>
                        <p>PENGURUS DAERAH KALIMANTAN TIMUR</p>
                    </div>
                </div>

                <div class="mt-10 max-w-sm">
                    <p class="italic">Alamat</p>
                    <p class="font-bold">Sekretariat : JL. Gatot Subroto, Srindit III No. 54 Samarinda 75117</p>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-6 p-12">
            {{-- <div class="text-2xl font-bold text-brand-primary">Hubungi Kami</div> --}}
            <div class="mt-10 max-w-sm">
                <p class="italic">Instagram</p>
                <a href="{{ $social['instagram'] }}" target="_blank"
                    class="font-bold hover:underline">{{ $social['instagram'] }}</a>
            </div>
            <div class="mt-10 max-w-sm">
                <p class="italic">Whatsapp</p>
                <a href="https://wa.me/{{ $social['whatsapp'] }}" target="_blank"
                    class="font-bold hover:underline">{{ $social['whatsapp'] }}</a>

            </div>
            <div class="mt-10 max-w-sm">
                <p class="italic">Email</p>
                <a href="mailto:{{ $social['email'] }}" target="_blank"
                    class="font-bold hover:underline">{{ $social['email'] }}</a>
            </div>
        </div>
    </div>
</div>
