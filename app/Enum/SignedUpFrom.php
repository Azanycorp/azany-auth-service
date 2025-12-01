<?php

namespace App\Enum;

enum SignedUpFrom: string
{
    case AZANY_B2C = 'azany_b2c';
    case AZANY_B2B = 'azany_b2b';
    case AZANYPAY = 'azanypay';
    case AVC = 'avc';
    case MIV = 'miv';
}

