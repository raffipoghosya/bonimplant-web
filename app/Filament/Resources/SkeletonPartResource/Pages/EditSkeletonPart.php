<?php

namespace App\Filament\Resources\SkeletonPartResource\Pages;

use App\Filament\Resources\SkeletonPartResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSkeletonPart extends EditRecord
{
    protected static string $resource = SkeletonPartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
