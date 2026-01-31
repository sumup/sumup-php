<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Month from the expiration time of the payment card. Accepted format is `MM`.
 */
enum CardExpiryMonth: string
{
    case VALUE_01 = '01';
    case VALUE_02 = '02';
    case VALUE_03 = '03';
    case VALUE_04 = '04';
    case VALUE_05 = '05';
    case VALUE_06 = '06';
    case VALUE_07 = '07';
    case VALUE_08 = '08';
    case VALUE_09 = '09';
    case VALUE_10 = '10';
    case VALUE_11 = '11';
    case VALUE_12 = '12';
}
