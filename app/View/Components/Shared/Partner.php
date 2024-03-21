<?php

namespace App\View\Components\Shared;

use App\Models\Partner as Model;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Partner extends Component
{
    protected $partners;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->partners = Model::get()->transform(fn ($item) => [
            'name' => $item->name,
            'logo' => env('APP_URL').'/'.'storage/'.$item->image,
            'website' => $item->website,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.partner', [
            'partners' => $this->partners,
        ]);
    }
}
