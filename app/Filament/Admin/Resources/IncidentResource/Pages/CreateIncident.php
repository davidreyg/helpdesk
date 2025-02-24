<?php

namespace App\Filament\Admin\Resources\IncidentResource\Pages;

use App\Filament\Admin\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncident extends CreateRecord
{
    protected static string $resource = IncidentResource::class;
}
