<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVideos extends ManageRecords
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $videoId = str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $data['link']);

                    $data['link'] = $videoId;

                    return $data;
                }),
        ];
    }
}
