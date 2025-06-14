<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReportTypeEnum: string implements HasLabel
{
    case COTIZACION = 'quotation-pdf';
    case ORDEN_COMPRA = 'purchase-pdf';

    public function getLabel(): string
    {
        return $this->value;
    }
}
