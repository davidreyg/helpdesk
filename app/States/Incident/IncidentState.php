<?php
namespace App\States\Incident;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<\App\Models\Incident>
 */
abstract class IncidentState extends State
{
    abstract public function color(): string;
    abstract public function label(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Solved::class)
        ;
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
