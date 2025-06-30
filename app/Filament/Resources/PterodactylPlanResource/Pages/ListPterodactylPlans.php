<?php

namespace App\Filament\Resources\PterodactylPlanResource\Pages;

use App\Filament\Resources\PterodactylPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPterodactylPlans extends ListRecords
{
    protected static string $resource = PterodactylPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
