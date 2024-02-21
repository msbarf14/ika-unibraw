<?php

namespace App\Models;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasFactory, HasUlids, SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    public function imgUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('images')
        );
    }

    public function documents(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getMedia('documents')
        );
    }

    public function formattedContent(): Attribute
    {
        return Attribute::make(
            get: function () {
                $temp = [];
                $total_word = 0;
                $word_limit = 70;
                foreach (explode('<p', $this->content) as $index => $item) {
                    $total_word += str_word_count(strip_tags($item));
                    $temp[] = $item;

                    if ($total_word >= $word_limit) {
                        break;
                    }
                }

                return implode('<p', $temp);
            }
        );
    }
}
