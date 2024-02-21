<?php

namespace App\Models\GuestBook;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'guestbooks_entries';

    protected $fillable = [
        'pic_id',
        'name',
        'phone',
        'agency',
        'needs',
        'date',
        'at',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function pic(): BelongsTo
    {
        return $this->belongsTo(Pic::class);
    }
}
