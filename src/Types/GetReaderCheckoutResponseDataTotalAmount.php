<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The checkout amount. The value uses two decimal places, even for currencies
 * such as CLP that use zero decimal places in the create request.
 *
 * For example, EUR 10.00 is returned as `1000` and CLP 1000 as `100000`.
 *
 */
class GetReaderCheckoutResponseDataTotalAmount
{
    /**
     * Currency ISO 4217 code
     *
     * @var string
     */
    public string $currency;

    /**
     * Integer value of the amount.
     *
     * @var int
     */
    public int $value;

}
