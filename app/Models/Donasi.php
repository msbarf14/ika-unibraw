<?php

namespace App\Models;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donasi extends Model
{
    use HasFactory, SoftDeletes, HasUlids;

    protected $table = 'donasi';

    protected $fillable = [
        'name',
        'phone',
        'message',
        'amount',
    ];
}
