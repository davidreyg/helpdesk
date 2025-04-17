<?php

namespace App\States\Incident;

class Solved extends IncidentState
{
    public static $name = 'solved';

    public function icon(): string
    {
        return 'tabler-check';
    }

    public function color(): string
    {
        return 'success';
    }

    public function label(): string
    {
        return __('statuses.solved');
    }
}
