<?php

namespace App\Filament\Resources\PterodactylPlanResource\Pages;

use App\Filament\Resources\PterodactylPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPterodactylPlan extends EditRecord
{
    protected static string $resource = PterodactylPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
