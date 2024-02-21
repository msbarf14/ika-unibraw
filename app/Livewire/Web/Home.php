<?php

namespace App\Livewire\Web;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    #[Layout('components.layouts.web')]
    #[Title('Beranda')]
    public function render()
    {
        return view('livewire.web.home');
    }
}
