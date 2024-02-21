<?php

namespace App\Models\Form;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Schema extends Model implements HasMedia
{
    use HasUlids, SortableTrait;
    use InteractsWithMedia;

    protected $table = 'form_schemas';

    protected $fillable = [
        'sort',
        'name',
        'slug',
        'schema',
        'meta',
    ];

    protected $casts = [
        'schema' => 'json',
        'meta' => 'json',
    ];

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => route('public-form', $this)
        );
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }
}
