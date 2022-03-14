<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Admin()
 * @method static static Member()
 */
final class UserType extends Enum
{
    const Admin = 1;
    const Member = 2;
}