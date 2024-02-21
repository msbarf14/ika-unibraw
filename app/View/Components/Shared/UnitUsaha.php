<?php

namespace App\View\Components\Shared;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UnitUsaha extends Component
{
    protected $unit;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->unit = Page::where('slug', 'LIKE', 'unit-usaha-%')
            ->latest('updated_at')
            ->get()->transform(fn ($page) => [
                'link' => sprintf('/%s', $page?->slug),
                'name' => $page?->title,
                'description' => $page?->formatted_content,
                'image' => $page?->img_url,
            ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.unit-usaha.index', [
            'units' => $this->unit,
        ]);
    }
}
