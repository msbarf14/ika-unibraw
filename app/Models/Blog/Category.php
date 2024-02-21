<?php

namespace App\Models\Blog;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'blog_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
    ];

    protected $casts = [];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
