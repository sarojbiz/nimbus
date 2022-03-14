<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Cancelled()
 * @method static static Completed()
 * @method static static Denied()
 * @method static static Expired()
 * @method static static Failed()
 * @method static static Pending()
 * @method static static Processed()
 * @method static static Processing()
 * @method static static Shipped()
 * @method static static Refunded()
 * @method static static Reversed()
 */
final class OrderStatus extends Enum
{
    const Cancelled = 5;
    const Completed = 4;
    const Denied = 6;
    const Expired = 7;
    const Failed = 10;
    const Pending = 0;
    const Processed = 2;
    const Processing = 1;
    const Shipped = 3;
    const Refunded = 8;
    const Reversed = 9;
}