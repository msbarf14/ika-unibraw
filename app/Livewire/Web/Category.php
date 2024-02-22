<?php

namespace App\Livewire\Web;

use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    #[Layout('components.layouts.web')]
    #[Title('Berita dan Informasi Terkini')]

    public BlogCategory $category;
    
    public function mount(BlogCategory $category)
    {
        $this->category = $category;
    }
    
    public function render()
    {
        return view('livewire.web.category', 
        [
            'news' => Post::latest('published_at')
                ->where('category_id', $this->category->id)
                ->paginate(12),
            'category' => $this->category
        ]);
    }

    public function paginationView()
    {
        return 'components.shared.pagination';
    }
}
