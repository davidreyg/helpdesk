<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum GenderEnum: string implements HasLabel
{
    case M = 'Male';
    case F = 'Female';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
