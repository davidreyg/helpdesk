<?php

namespace App\States\Incident;

class Pending extends IncidentState
{
    public static $name = 'pending';

    public function getIcon(): string
    {
        return 'tabler-hourglass-empty';
    }

    public function getColor(): string
    {
        return 'info';
    }

    public function getLabel(): string
    {
        return __('statuses.pending');
    }
}
