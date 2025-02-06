<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case DNI = 'D.N.I';
    case RUC = 'R.U.C';
    case FOREIGNER_ID_CARD = 'Foreigner ID CARD';
}
