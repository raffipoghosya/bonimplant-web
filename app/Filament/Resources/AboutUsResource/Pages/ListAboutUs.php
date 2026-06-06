<?php
namespace App\Filament\Resources\AboutUsResource\Pages;
use App\Filament\Resources\AboutUsResource;
use App\Models\AboutUs;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListAboutUs extends ListRecords {
    protected static string $resource = AboutUsResource::class;
    public function mount(): void {
        // Ensure singleton exists then redirect to edit
        $instance = AboutUs::instance();
        $this->redirect(AboutUsResource::getUrl('edit', ['record' => $instance->id]));
    }
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
