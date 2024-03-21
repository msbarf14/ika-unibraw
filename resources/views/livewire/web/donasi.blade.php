<div>
    <x-shared.navigation />
    <div class="relative min-h-[80vh] py-16 overflow-hidden bg-white">
        <x-shared.decoration />

        {{-- Main Content --}}
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mx-auto text-lg max-w-prose">
                <h1>
                    <span
                        class="block mt-2 text-3xl font-extrabold leading-8 tracking-tight text-center text-gray-900 sm:text-3xl">Formulir
                        Donasi</span>
                </h1>
            </div>

            <div class="max-w-7xl mx-auto mt-10 ">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
                    <div>

                        Rekening MANDIRI : 1490024092027
                        A.n : Perkumpulan Ikatan Alumni Universitas Brawijaya . Kalimantan Timur
                        KCP Balikpapan Sudirman
                    </div>
                    <div class="border bg-white rounded-xl px-4 pb-5" x-data="{
                        time: {
                            active: @entangle('active'),
                            left: @entangle('timer'),
                            label: null,
                            message: null,
                            timer: null
                        },
                        checkTime() {
                            if (this.time.active) {
                                var minutes = Math.floor((this.time.left % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((this.time.left % (1000 * 60)) / 1000);
                    
                                if (this.time.left) {
                                    this.time.label = [minutes, 'menit', seconds, 'detik'].join(' ')
                                    this.time.left -= 1000
                                } else {
                                    $wire.set('timer', 0)
                                    $wire.set('active', false)
                                    this.time.label = null
                                    this.time.message = 'Waktu OTP telah habis silakan request kembali'
                                    clearInterval(this.time.timer);
                                }
                            }
                        }
                    }" x-init="$watch('time.active', value => {
                        if (value) {
                            time.message = null
                            time.timer = setInterval(() => checkTime(), 1000)
                        }
                    })">
                        <form wire:submit.prevent="submit">
                            <div class="mt-8">
                                <x-shared.forms.text-input wire:model="nama" name="nama" label="Nama"
                                    help="Nama Anda" />
                            </div>

                            <div class="mt-8">
                                <x-shared.forms.text-input wire:model="phone" name="phone" label="Nomor Whatsapp"
                                    help="Nomor Whatsapp Anda" x-mask="9999 9999 9999 9999" />
                            </div>

                            <div class="mt-8">
                                <x-shared.forms.text-input wire:model="pesan" name="pesan" label="Pesan"
                                    help="Pesan Anda" textarea rows=5 />
                            </div>

                            <div class="mt-8">
                                <x-shared.forms.text-input wire:model="otp" name="otp" label="OTP"
                                    x-mask="9999" />
                            </div>

                            <div x-cloak x-show="time.message" x-text="time.message" class="mt-8 -mb-8 text-red-500">
                            </div>
                            <div class="flex justify-between mt-8">
                                <button x-cloak x-show="!time.active" wire:click="getOtp" type="button"
                                    class="text-brand-blue">
                                    <span wire:loading.remove wire:target="getOtp">
                                        Minta kode OTP
                                    </span>
                                    <span wire:loading class="text-gray-400" wire:target="getOtp">Mohon tunggu
                                        ...</span>
                                </button>
                                <span x-cloak x-show="time.active" class="text-brand-blue" x-text="time.label"></span>

                                <button type="submit" @class([
                                    'inline-flex items-center px-4 py-2 font-medium text-white border border-transparent rounded shadow-sm',
                                    'focus:outline-none focus:ring-2 focus:ring-offset-2',
                                    'bg-brand-blue hover:bg-brand-blue/80 focus:ring-brand-blue disabled:cursor-not-allowed',
                                ]) wire:loading.class="opacity-50"
                                    wire:target="submit">
                                    <x-filament::loading-indicator wire:loading wire:target="submit"
                                        class="w-5 h-5 mr-3" />
                                    Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-shared.footer />
</div>
