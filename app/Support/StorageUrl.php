<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class StorageUrl
{
    public static function inHtml(?string $html): ?string
    {
        if (blank($html)) {
            return $html;
        }

        return preg_replace_callback(
            '~(?P<quote>["\'])(?:(?:https?:)?//[^"\']+)?/storage/(?P<path>[^"\'?#]+)(?:[?#][^"\']*)?(?P=quote)~i',
            static fn (array $match): string => $match['quote']
                .Storage::disk(config('filesystems.default'))->url(urldecode($match['path']))
                .$match['quote'],
            $html,
        );
    }
}
