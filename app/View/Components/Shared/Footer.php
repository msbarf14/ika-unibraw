<?php

namespace App\View\Components\Shared;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Footer extends Component
{
    protected $socialMedia;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->socialMedia = Cache::remember('web.settings.social-media', now()->addMinutes(3), function () {
            return Arr::undot(Setting::where('key', 'LIKE', 'social-media.%')->pluck('value', 'key'))['social-media'] ?? [];
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.footer', [
            'social_media' => $this->socialMedia,
        ]);
    }
}
