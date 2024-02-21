<?php

namespace App\Models;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Navigation extends Model implements Sortable
{
    use HasFactory, HasUlids;
    use SoftDeletes, SortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sort',
        'type',
        'name',
        'url',
        'childs',
        'meta',
    ];

    protected $casts = [
        'childs' => 'json',
        'meta' => 'json',
    ];

    protected static function booted(): void
    {
        static::updated(function (Navigation $record) {
            if ($record->isParent() && $record->wasChanged('sort')) {
                Navigation::where('parent_id', $record->id)->update();
            }
        });
    }

    public function scopeParentOnly($query)
    {
        $query->whereNull('parent_id');
    }

    public function isParent(): bool
    {
        return ! $this->parent_id;
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function grandChild()
    {
        return $this->hasMany(grandChild::class);
    }
}
