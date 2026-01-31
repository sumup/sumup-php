<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * __Required when payment type is `card`.__ Details of the payment card.
 */
class Card
{
    /**
     * Name of the cardholder as it appears on the payment card.
     *
     * @var string
     */
    public string $name;

    /**
     * Number of the payment card (without spaces).
     *
     * @var string
     */
    public string $number;

    /**
     * Year from the expiration time of the payment card. Accepted formats are `YY` and `YYYY`.
     *
     * @var string
     */
    public string $expiryYear;

    /**
     * Month from the expiration time of the payment card. Accepted format is `MM`.
     *
     * @var CardExpiryMonth
     */
    public CardExpiryMonth $expiryMonth;

    /**
     * Three or four-digit card verification value (security code) of the payment card.
     *
     * @var string
     */
    public string $cvv;

    /**
     * Required five-digit ZIP code. Applicable only to merchant users in the USA.
     *
     * @var string|null
     */
    public ?string $zipCode = null;

    /**
     * Last 4 digits of the payment card number.
     *
     * @var string
     */
    public string $last4Digits;

    /**
     * Issuing card network of the payment card used for the transaction.
     *
     * @var CardType
     */
    public CardType $type;

}
