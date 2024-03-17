<?php

namespace App\View\Components\Shared;

use App\Models\Blog\Post;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Information extends Component
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
        return view('components.shared.information', [
            'konseling' => Post::query()->whereHas('category', function ($query) {
                return $query->where('slug', 'konseling');
            })
                ->take(6)
                ->get()
                ->transform(fn ($item) => [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'date' => Carbon::parse($item['published_at'])->format('d-m-Y'),
                ]),
            'kerjasama' => Post::query()->whereHas('category', function ($query) {
                return $query->where('slug', 'kerjasama');
            })
                ->take(6)
                ->get()
                ->transform(fn ($item) => [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'date' => Carbon::parse($item['published_at'])->format('d-m-Y'),
                ]),
            'karir' => Post::query()->whereHas('category', function ($query) {
                return $query->where('slug', 'karir');
            })
                ->take(6)
                ->get()
                ->transform(fn ($item) => [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'date' => Carbon::parse($item['published_at'])->format('d-m-Y'),
                ]),
        ]);
    }
}
