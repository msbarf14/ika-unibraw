<?php

namespace App\Livewire\Web;

use App\Models\Page as Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Page extends Component
{
    public Model $page;

    #[Layout('components.layouts.web')]
    public function render()
    {
        return view('livewire.web.page', [
            'page' => $this->page,
        ])->title($this->page->title);
    }
}
