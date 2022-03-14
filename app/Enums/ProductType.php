<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Disabled()
 * @method static static Enabled()
 */
final class ProductType extends Enum
{
    const Simple = 0;
    const variable = 1;
}