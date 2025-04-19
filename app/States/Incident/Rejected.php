<?php

namespace App\States\Incident;

class Rejected extends IncidentState
{
    public static $name = 'rejected';

    public function getIcon(): string
    {
        return 'tabler-cancel';
    }

    public function getColor(): string
    {
        return 'danger';
    }

    public function getLabel(): string
    {
        return __('statuses.rejected');
    }
}
