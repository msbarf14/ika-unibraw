<?php

namespace App\Models\Form;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasUlids;

    protected $table = 'form_collections';

    protected $fillable = [
        'schema_id',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function schema(): BelongsTo
    {
        return $this->belongsTo(Schema::class);
    }
}
