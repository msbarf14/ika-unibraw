<?php

namespace App\Models\Donasi;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'donation_campaigns';
    protected $fillable = [
        'title',
        'image',
        'description',
        'open',
        'display_amount',
        'amount',
    ];

    protected $casts = [
        'open' => 'boolean',
        'display_amount'  => 'boolean',
    ];

    public function campaign() : HasMany
    {
        return $this->hasMany(Transaction::class, 'campaign_id', 'id');
    }

}
