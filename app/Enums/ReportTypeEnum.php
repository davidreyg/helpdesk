<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReportTypeEnum: string implements HasLabel
{
    case COTIZACION = 'cotizacion-pdf';

    public function getLabel(): ?string
    {
        return $this->value;
    }

}
