<?php

namespace App\Enum;

enum UserType: string
{
    case B2C_CUSTOMER = 'b2c_customer';
    case B2C_SELLER = 'b2c_seller';
    case AGRIECOM_B2C_CUSTOMER = 'agriecom_b2c_customer';
    case AGRIECOM_B2C_SELLER = 'agriecom_b2c_seller';
    case B2B_CUSTOMER = 'b2b_customer';
    case B2B_SELLER = 'b2b_seller';
    case AGRIECOM_B2B_CUSTOMER = 'agriecom_b2b_customer';
    case AGRIECOM_B2B_SELLER = 'agriecom_b2b_seller';
    case AVC_USER = 'avc_user';
    case MIV_USER = 'miv_user';
    case AZANYPAY_USER = 'azanypay_user';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
