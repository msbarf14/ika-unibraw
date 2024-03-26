<?php

namespace App\View\Components\Shared;

use App\Models\Blog\Post;
use App\Models\Video;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Selection extends Component
{
    protected $news;
    protected $videos;
   
    public function __construct()
    {
        $this->news = Post::with('category')
        ->latest('published_at')
        ->where('is_pin', 0)
        ->whereHas('category', function($query) {
            return $query->where('slug', 'pilihan');
        })
        ->take(3)
        ->get()
        ->transform(fn ($post) => [
            'id' => $post->ulid,
            'slug' => $post->slug,
            'title' => $post->title,
            'content' => $post->content,
            'tags' => $post->tags,
            'image' => $post->img_url,
            'published_at' => $post->published_at
        ]);

        $this->videos = Video::latest('created_at')
            ->where('active', 1)
            ->take(1)
            ->get();
    }


    public function render(): View|Closure|string
    {
        return view('components.shared.selection', [
            'news' => $this->news,
            'videos' => $this->videos,
        ]);
    }
}
