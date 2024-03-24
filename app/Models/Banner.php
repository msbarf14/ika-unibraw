<?php

namespace App\Models;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'banners';

    protected $fillable = [
        'image',
        'location'
    ];
}
