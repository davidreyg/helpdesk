<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CurrencyEnum: string implements HasLabel
{
    case DOLARES = 'USD';
    case SOLES = 'PEN';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
