<?php

namespace App\Models\GuestBook;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pic extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'guestbooks_pics';

    protected $fillable = [
        'name',
        'position',
        'phone',
    ];

    protected $casts = [];

    public function entry(): HasMany
    {
        return $this->hasMany(Entry::class);
    }
}
