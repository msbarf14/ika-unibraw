<?php

namespace App\Livewire\Web;

use App\Models\Blog\Post;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Search extends Component
{

    public $query = '';
    public $news;

    #[Layout('components.layouts.web')]
    #[Title('Pencarian')]

    public function mount(Request $request)
    {
        $this->query = $request->get('query');
        $this->news = Post::query()
            ->where('title', 'LIKE', '%' . $request->get('query') . '%')
            ->latest()
            ->get();
    }
    public function render()
    {
        return view('livewire.web.search');
    }
}
