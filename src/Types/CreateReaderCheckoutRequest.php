<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Reader Checkout
 */
class CreateReaderCheckoutRequest
{
    /**
     * Affiliate metadata for the transaction.
     * It is a field that allow for integrators to track the source of the transaction.
     *
     * @var array<string, mixed>|null
     */
    public ?array $affiliate = null;

    /**
     * The card type of the card used for the transaction.
     * Is is required only for some countries (e.g: Brazil).
     *
     * @var CreateReaderCheckoutRequestCardType|null
     */
    public ?CreateReaderCheckoutRequestCardType $cardType = null;

    /**
     * Description of the checkout to be shown in the Merchant Sales
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Number of installments for the transaction.
     * It may vary according to the merchant country.
     * For example, in Brazil, the maximum number of installments is 12.
     * Omit if the merchant country does support installments.
     * Otherwise, the checkout will be rejected.
     *
     * @var int|null
     */
    public ?int $installments = null;

    /**
     * Webhook URL to which the payment result will be sent.
     * It must be a HTTPS url.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * List of tipping rates to be displayed to the cardholder.
     * The rates are in percentage and should be between 0.01 and 0.99.
     * The list should be sorted in ascending order.
     *
     * @var float[]|null
     */
    public ?array $tipRates = null;

    /**
     * Time in seconds the cardholder has to select a tip rate.
     * If not provided, the default value is 30 seconds.
     * It can only be set if `tip_rates` is provided.
     * **Note**: If the target device is a Solo, it must be in version 3.3.38.0 or higher.
     *
     * @var int|null
     */
    public ?int $tipTimeout = null;

    /**
     * Amount structure.
     * The amount is represented as an integer value altogether with the currency and the minor unit.
     * For example, EUR 1.00 is represented as value 100 with minor unit of 2.
     *
     * @var array<string, mixed>
     */
    public array $totalAmount;

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if ($data !== []) {
            \SumUp\Hydrator::hydrate($data, self::class, $this);
        }
    }

}
