<?php

namespace App\View\Components\Shared;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class About extends Component
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
        return view('components.shared.about', [
            'about' => Cache::remember('web.about.landing', now()->addMinute(3), function () {
                $setting = Setting::where('key', 'LIKE', 'about.%')->pluck('value', 'key');

                return [
                    'message' => $setting['about.landing'] ?? null,
                ];
            }),
        ]);
    }
}
