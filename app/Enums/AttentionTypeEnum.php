<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttentionTypeEnum: string implements HasLabel
{
    case Solicitud = 'Solicitud';
    case Requerimiento = 'Requerimiento';

    public function getLabel(): string
    {
        return $this->value;
    }
}
