<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentTypeEnum: string implements HasLabel
{
    case DNI = 'D.N.I';
    case RUC = 'R.U.C';
    case FOREIGNER_ID_CARD = 'Carné de extranjeria';

    public function getLabel(): ?string
    {
        return $this->value;
    }

}
