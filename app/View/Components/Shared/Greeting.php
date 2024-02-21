<?php

namespace App\View\Components\Shared;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Greeting extends Component
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
        return view('components.shared.greeting', [
            'greet' => Cache::remember('web.settings.greeting', now()->addMinutes(3), function () {
                $setting = Setting::where('key', 'LIKE', 'greeting.%')->pluck('value', 'key');

                $photoPath = $setting['greeting.photo'] ?? '';

                $disk = Storage::disk('public')->exists($photoPath) ? 'public' : 'upcloud';

                /**
                 * @var Storage $storage
                 */
                $storage = Storage::disk($disk);

                $photoUrl = $storage->url($photoPath);

                return [
                    'photo' => $photoUrl,
                    'name' => $setting['greeting.speaker'] ?? null,
                    'occupation' => $setting['greeting.occupation'] ?? null,
                    'message' => $setting['greeting.message'] ?? null,
                ];
            }),
        ]);
    }
}
