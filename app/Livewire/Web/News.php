<?php

namespace App\Livewire\Web;

use App\Models\Blog\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class News extends Component
{
    use WithPagination;

    #[Layout('components.layouts.web')]
    #[Title('Berita dan Informasi Terkini')]
    public function render()
    {
        return view('livewire.web.news', [
            'news' => Post::latest('published_at')->paginate(12),
        ]);
    }

    public function paginationView()
    {
        return 'components.shared.pagination';
    }
}
