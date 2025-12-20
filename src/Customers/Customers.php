<?php

declare(strict_types=1);

namespace SumUp\Customers;

/**
 * Issuing card network of the payment card used for the transaction.
 */
enum ModelType: string
{
    case AMEX = 'AMEX';
    case CUP = 'CUP';
    case DINERS = 'DINERS';
    case DISCOVER = 'DISCOVER';
    case ELO = 'ELO';
    case ELV = 'ELV';
    case HIPERCARD = 'HIPERCARD';
    case JCB = 'JCB';
    case MAESTRO = 'MAESTRO';
    case MASTERCARD = 'MASTERCARD';
    case VISA = 'VISA';
    case VISA_ELECTRON = 'VISA_ELECTRON';
    case VISA_VPAY = 'VISA_VPAY';
    case UNKNOWN = 'UNKNOWN';
}

/**
 * Type of the payment instrument.
 */
enum PaymentInstrumentResponseType: string
{
    case CARD = 'card';
}

class Customer
{
    /**
     * Unique ID of the customer.
     *
     * @var string
     */
    public string $customerId;

    /**
     * Personal details for the customer.
     *
     * @var \SumUp\Shared\PersonalDetails|null
     */
    public ?\SumUp\Shared\PersonalDetails $personalDetails = null;

}

/**
 * Payment Instrument Response
 */
class PaymentInstrumentResponse
{
    /**
     * Unique token identifying the saved payment card for a customer.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * Indicates whether the payment instrument is active and can be used for payments. To deactivate it, send a `DELETE` request to the resource endpoint.
     *
     * @var bool|null
     */
    public ?bool $active = null;

    /**
     * Type of the payment instrument.
     *
     * @var PaymentInstrumentResponseType|null
     */
    public ?PaymentInstrumentResponseType $type = null;

    /**
     * Details of the payment card.
     *
     * @var array|null
     */
    public ?array $card = null;

    /**
     * Created mandate
     *
     * @var \SumUp\Shared\MandateResponse|null
     */
    public ?\SumUp\Shared\MandateResponse $mandate = null;

    /**
     * Creation date of payment instrument. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $createdAt = null;

}
