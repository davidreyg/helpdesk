<?php
namespace App\States\Incident;


class Rejected extends IncidentState
{
    public static $name = 'rejected';

    public function color(): string
    {
        return 'danger';
    }

    public function label(): string
    {
        return __('statuses.rejected');
    }
}
