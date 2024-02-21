<div>
  <x-shared.navigation />
  <div class="max-w-3xl p-6 mx-auto space-y-6">
    <div>
      <h2 class="text-xl font-bold text-center">Buku Tamu</h2>
    </div>
    <form wire:submit="create">
      {{ $this->form }}

      <button size="lg" class="btn mt-5 bg-[#00935F] text-white" type="submit" wire:target="create"
        wire:loading.class="opacity-50">
        <x-filament::loading-indicator wire:loading wire:target="create" class="h-5 w-5 mr-3" />
        Kirim
      </button>
    </form>
  </div>

  <x-filament-actions::modals />
</div>
