<?php
namespace App\States\Incident;


class Solved extends IncidentState
{
    public static $name = 'solved';

    public function color(): string
    {
        return 'info';
    }

    public function label(): string
    {
        return __('statuses.solved');
    }
}
