<?php

namespace App\Models;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, HasUlids;
    use SoftDeletes;

    protected $table = 'videos';

    protected $fillable = [
        'title',
        'description',
        'link',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

}
