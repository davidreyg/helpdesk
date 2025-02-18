<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentTypeEnum: string implements HasLabel
{
    case EFECTIVO = 'CASH';
    case TARJETA = 'CREDIT CARD';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
