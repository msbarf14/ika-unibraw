<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
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
        $navigations = \App\Models\Navigation::orderBy('sort')->get()->transform(fn ($item) => [
            'name' => $item->name,
            'url' => $item->url,
            'childs' => collect($item->childs)->map(fn ($child) => [
                'name' => $child['name'],
                'url' => $child['url'],
                'childs' => collect($child['childs'])->map(fn ($child) => [
                    'name' => $child['name'],
                    'url' => $child['url'],
                ]),
            ]),
        ]);

        return view('components.shared.navigation.index', [
            'navigations' => $navigations,
        ]);
    }
}
