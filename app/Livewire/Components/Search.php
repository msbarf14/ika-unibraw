<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Search extends Component
{
    public $query = '';

    public function search() 
    {
        return redirect()->route('post.search', ['query' => $this->query]);
    }
    public function render()
    {
        return view('livewire.components.search');
    }
}
