<?php

namespace App\Filament\Admin\Resources\IncidentResource\Pages;

use App\Filament\Admin\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIcidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
