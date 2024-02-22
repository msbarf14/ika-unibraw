<?php

namespace App\View\Components\Shared;

use App\Models\Blog\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Collaboration extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.collaboration', 
            [
                'collaboration' => Post::query()->whereHas('category', function($query) {
                    return $query->where('slug', 'kerjasama');
                })->paginate(5),
                'careers' => Post::query()->whereHas('category', function($query) {
                    return $query->where('slug', 'karir');
                })->paginate(5)
            ]
        );
    }
}
