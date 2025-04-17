<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentTypeEnum: string implements HasLabel
{
    case EFECTIVO = 'EFECTIVO';
    case CREDITO = 'CREDITO';
    case TRANSFERENCIA = 'TRANSFERENCIA';
    case YAPE = 'YAPE';
    case PLIN = 'PLIN';

    public function getLabel(): string
    {
        return $this->name;
    }
}
