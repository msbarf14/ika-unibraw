<?php

namespace App\Livewire\Web;

use App\Models\Donasi\Campaign;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Donasi extends Component
{
    use WithPagination;

    #[Title('Donasi')]
    #[Layout('components.layouts.web')]

    public function render()
    {
        return view('livewire.web.donasi', [
            'campaigns' => Campaign::where('open', 1)
                ->latest()
                ->paginate(12)
        ]);
    }

    public function paginationView()
    {
        return 'components.shared.pagination';
    }
}
