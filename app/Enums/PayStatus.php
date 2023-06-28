<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PayStatus extends Enum
{
    const UNPAID = 0;
    const PAID = 1;
    const PAYMENTFAILED = 2;

    const DESTROY = 3;
}
