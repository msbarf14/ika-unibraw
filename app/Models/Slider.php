<?php

namespace App\Models;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use HasFactory, HasUlids, SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'link',
        'button_style',
        'type',
    ];

    public function backgroundUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('backgrounds')
        );
    }

    public function illustrationUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('illustrations')
        );
    }

    public function buttonColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->button_style) {
                'orange' => 'bg-brand-orange hover:bg-brand-orange/80 focus:ring-brand-orange',
                'blue' => 'bg-brand-blue hover:bg-brand-blue/80 focus:ring-brand-blue',
                'blue-2' => 'bg-[#49629B] hover:bg-[#49629B]/80 focus:ring-[#49629B]',
                'green' => 'bg-brand-green hover:bg-brand-green/80 focus:ring-brand-green',
                'white' => 'bg-white hover:bg-gray-50 focus:ring-white text-black',
                'black' => 'bg-black hover:bg-gray-900 focus:ring-black text-white',
                default => 'bg-blue-600 hover:bg-blue-700 ring-offset-white focus:ring-blue-500',
            }
        );
    }
}
