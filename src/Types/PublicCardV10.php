<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Card brand, credit/debit processing type, and last four digits.
 */
class PublicCardV10
{
    /**
     * The brand of the card.
     * Input is case-insensitive; the canonical form is lowercase snake_case.
     * **VALUES**: [amex, cup, diners, discover, elo, elv, hipercard, jcb, maestro, mastercard, visa, visa_electron,
     * visa_vpay, vr, eftpos, conecs, swile, girocard, interac, sumup, bancomat].
     *
     * @var string
     */
    public string $brand;

    /**
     * Credit or debit processing choice, not brand or funding.
     * `unknown` when unavailable; prepaid/voucher are not processing types.
     *
     * @var PublicCardV10Type
     */
    public PublicCardV10Type $type;

    /**
     * The last 4 digits of the card used for the payment.
     *
     * @var string
     */
    public string $last4Digits;

}
