<?php
namespace App\Filament\Resources\BodyPartResource\Pages;
use App\Filament\Resources\BodyPartResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListBodyParts extends ListRecords {
    protected static string $resource = BodyPartResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
