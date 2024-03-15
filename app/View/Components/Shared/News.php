<?php

namespace App\View\Components\Shared;

use App\Models\Blog\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class News extends Component
{
    protected $news;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->news = Post::latest('published_at')->take(3)->get()->transform(fn ($post) => [
            'id' => $post->ulid,
            'slug' => $post->slug,
            'title' => $post->title,
            'tags' => $post->tags,
            'image' => $post->img_url,
            'published_at' => $post->published_at
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.news', [
            'news' => $this->news,
        ]);
    }
}
