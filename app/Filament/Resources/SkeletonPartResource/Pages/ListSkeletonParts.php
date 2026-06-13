<?php

namespace App\Filament\Resources\SkeletonPartResource\Pages;

use App\Filament\Resources\SkeletonPartResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSkeletonParts extends ListRecords
{
    protected static string $resource = SkeletonPartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
