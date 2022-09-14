<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CashOnDelivery()
 */
final class PaymentMethod extends Enum
{
    const CashOnDelivery = 1;
    //const CardPayment = 2;
    //const Esewa = 3;
    //const FonepayOnDelivery = 4;
    //const Fonepay = 5;
    //const ImePay = 6;
    //const ConnectIps = 7;


    public static function getDescription($value): string
    {
        if ($value === self::ConnectIps) {
            return 'connectIPS - Pay Direct From Bank';
        }

        return parent::getDescription($value);
    }
}
