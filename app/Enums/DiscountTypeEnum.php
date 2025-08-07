<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DiscountTypeEnum: string implements HasLabel
{
    case PERCENT = 'Porcentaje';
    case FIXED = 'Monto Fijo';

    public function getLabel(): string
    {
        return $this->value;
    }
}
