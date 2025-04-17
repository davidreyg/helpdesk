<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PriorityEnum: string implements HasLabel
{
    case HIGH = 'Alto';
    case MEDIUM = 'Medio';
    case LOW = 'Bajo';

    public function getLabel(): string
    {
        return $this->value;
    }
}
