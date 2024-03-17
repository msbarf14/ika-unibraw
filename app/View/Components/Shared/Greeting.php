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
            'greet' => Cache::remember('web.settings.greeting', now()->addMinute(3), function () {
                $setting = Setting::where('key', 'LIKE', 'greeting%')->pluck('value', 'key');
                
                // penasehat
                $photoPath = $setting['greeting.photo'] ?? '';
                // ketua
                $photoPath1 = $setting['greeting1.photo'] ?? '';

                $disk = Storage::disk('public')->exists($photoPath) ? 'public' : 'upcloud';
                $storage = Storage::disk($disk);

                return [
                    'photo-penasehat' => $storage->url($photoPath),
                    'name-penasehat' => $setting['greeting.speaker'] ?? null,
                    'occupation-penasehat' => $setting['greeting.occupation'] ?? null,
                    'message-penasehat' => $setting['greeting.message'] ?? null,
                    'photo-ketua' => $storage->url($photoPath1),
                    'name-ketua' => $setting['greeting1.speaker'] ?? null,
                    'occupation-ketua' => $setting['greeting1.occupation'] ?? null,
                    'message-ketua' => $setting['greeting1.message'] ?? null,
                ];
            }),
        ]);
    }
}
