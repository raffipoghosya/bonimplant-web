<?php
namespace App\Filament\Resources\BodyPartResource\Pages;
use App\Filament\Resources\BodyPartResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditBodyPart extends EditRecord {
    protected static string $resource = BodyPartResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
