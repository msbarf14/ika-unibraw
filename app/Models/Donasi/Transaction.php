<?php

namespace App\Models\Donasi;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'donation_transactions';
    protected $fillable = [
        'campaign_id',
        'name',
        'phone',
        'message',
        'attachment',
        'paid',
    ];

    protected $casts = [
        'open' => 'paid',
    ];

    public function campaign() : BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}
