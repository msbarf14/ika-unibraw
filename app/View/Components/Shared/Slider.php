<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Slider extends Component
{
    protected $sliders;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->sliders = \App\Models\Slider::latest()->get()->transform(fn ($slider) => [
            'id' => $slider->id,
            'title' => $slider->title,
            'slug' => $slider->slug,
            'type' => $slider->type,
            'description' => $slider->description,
            'link' => $slider->link,
            'button_style' => $slider->button_color,
            'background' => $slider->background_url,
            'illustration' => $slider->illustration_url,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.slider', [
            'sliders' => $this->sliders,
        ]);
    }
}
