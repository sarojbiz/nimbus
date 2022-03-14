<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Disabled()
 * @method static static Enabled()
 */
final class GeneralStatus extends Enum
{
    const Disabled = 0;
    const Enabled = 1;
}