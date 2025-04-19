<?php

namespace App\States\Incident;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<\App\Models\Incident>
 */
abstract class IncidentState extends State implements HasColor, HasIcon, HasLabel
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Solved::class)
            ->allowTransition(Pending::class, Rejected::class);
    }

    public function transitionableStatesFormatted(): array
    {
        return collect($this->transitionableStates())
            ->mapWithKeys(function ($state) {
                $stateClass = 'App\\States\\Incident\\' . ucfirst($state);

                return [$state => (new $stateClass($this))->label()];
            })
            ->toArray();
    }
}
