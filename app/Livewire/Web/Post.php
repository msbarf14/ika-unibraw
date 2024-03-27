<?php

namespace App\Livewire\Web;

use App\Models\Blog\Post as Model;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOTools;
class Post extends Component
{
    public Model $post;

    #[Layout('components.layouts.web')]
    public function render()
    {

        return view('livewire.web.post', [
            'post' => $this->post,
        ])
            ->title($this->post->title);
    }
}
