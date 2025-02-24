<?php
namespace App\States\Incident;


class Pending extends IncidentState
{
    public static $name = 'pending';

    public function color(): string
    {
        return 'info';
    }

    public function label(): string
    {
        return __('statuses.pending');
    }
}
