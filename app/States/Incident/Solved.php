<?php

namespace App\States\Incident;

class Solved extends IncidentState
{
    public static $name = 'solved';

    public function getIcon(): string
    {
        return 'tabler-check';
    }

    public function getColor(): string
    {
        return 'success';
    }

    public function getLabel(): string
    {
        return __('statuses.solved');
    }
}
