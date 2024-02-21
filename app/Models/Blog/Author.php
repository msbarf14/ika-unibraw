<?php

namespace App\Models\Blog;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'blog_authors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'instagram',
        'twitter',
        'biography',
    ];

    protected $casts = [];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
