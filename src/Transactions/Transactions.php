<?php

declare(strict_types=1);

namespace SumUp\Transactions;

/**
 * Issuing card network of the payment card used for the transaction.
 */
enum CardResponseType: string
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
 * Status of the transaction event.
 */
enum EventStatus: string
{
    case PENDING = 'PENDING';
    case SCHEDULED = 'SCHEDULED';
    case FAILED = 'FAILED';
    case REFUNDED = 'REFUNDED';
    case SUCCESSFUL = 'SUCCESSFUL';
    case PAID_OUT = 'PAID_OUT';
}

/**
 * Type of the transaction event.
 */
enum EventType: string
{
    case PAYOUT = 'PAYOUT';
    case CHARGE_BACK = 'CHARGE_BACK';
    case REFUND = 'REFUND';
    case PAYOUT_DEDUCTION = 'PAYOUT_DEDUCTION';
}

/**
 * Issuing card network of the payment card used for the transaction.
 */
enum ModelCardType: string
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
 * Payout type for the transaction.
 */
enum ModelPayoutType: string
{
    case BANK_ACCOUNT = 'BANK_ACCOUNT';
    case BALANCE = 'BALANCE';
    case PREPAID_CARD = 'PREPAID_CARD';
}

/**
 * Simple name of the payment type.
 */
enum ModelSimplePaymentType: string
{
    case MOTO = 'MOTO';
    case CASH = 'CASH';
    case CC_SIGNATURE = 'CC_SIGNATURE';
    case ELV = 'ELV';
    case CC_CUSTOMER_ENTERED = 'CC_CUSTOMER_ENTERED';
    case MANUAL_ENTRY = 'MANUAL_ENTRY';
    case EMV = 'EMV';
}

/**
 * Status generated from the processing status and the latest transaction state.
 */
enum ModelSimpleStatus: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case PAID_OUT = 'PAID_OUT';
    case CANCEL_FAILED = 'CANCEL_FAILED';
    case CANCELLED = 'CANCELLED';
    case CHARGEBACK = 'CHARGEBACK';
    case FAILED = 'FAILED';
    case REFUND_FAILED = 'REFUND_FAILED';
    case REFUNDED = 'REFUNDED';
    case NON_COLLECTION = 'NON_COLLECTION';
}

/**
 * Verification method used for the transaction.
 */
enum ModelVerificationMethod: string
{
    case NONE = 'none';
    case NA = 'na';
    case SIGNATURE = 'signature';
    case OFFLINE_PIN = 'offline PIN';
    case ONLINE_PIN = 'online PIN';
    case OFFLINE_PIN_PLUS_SIGNATURE = 'offline PIN + signature';
    case CONFIRMATION_CODE_VERIFIED = 'confirmation code verified';
}

/**
 * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
 */
enum TransactionBaseCurrency: string
{
    case BGN = 'BGN';
    case BRL = 'BRL';
    case CHF = 'CHF';
    case CLP = 'CLP';
    case CZK = 'CZK';
    case DKK = 'DKK';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case HRK = 'HRK';
    case HUF = 'HUF';
    case NOK = 'NOK';
    case PLN = 'PLN';
    case RON = 'RON';
    case SEK = 'SEK';
    case USD = 'USD';
}

/**
 * Payment type used for the transaction.
 */
enum TransactionBasePaymentType: string
{
    case CASH = 'CASH';
    case POS = 'POS';
    case ECOM = 'ECOM';
    case RECURRING = 'RECURRING';
    case BITCOIN = 'BITCOIN';
    case BALANCE = 'BALANCE';
    case MOTO = 'MOTO';
    case BOLETO = 'BOLETO';
    case DIRECT_DEBIT = 'DIRECT_DEBIT';
    case APM = 'APM';
    case UNKNOWN = 'UNKNOWN';
}

/**
 * Current status of the transaction.
 */
enum TransactionBaseStatus: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case CANCELLED = 'CANCELLED';
    case FAILED = 'FAILED';
    case PENDING = 'PENDING';
}

/**
 * Entry mode of the payment details.
 */
enum TransactionCheckoutInfoEntryMode: string
{
    case BOLETO = 'BOLETO';
    case SOFORT = 'SOFORT';
    case IDEAL = 'IDEAL';
    case BANCONTACT = 'BANCONTACT';
    case EPS = 'EPS';
    case MYBANK = 'MYBANK';
    case SATISPAY = 'SATISPAY';
    case BLIK = 'BLIK';
    case P_24 = 'P24';
    case GIROPAY = 'GIROPAY';
    case PIX = 'PIX';
    case QR_CODE_PIX = 'QR_CODE_PIX';
    case APPLE_PAY = 'APPLE_PAY';
    case GOOGLE_PAY = 'GOOGLE_PAY';
    case PAYPAL = 'PAYPAL';
    case NONE = 'NONE';
    case CHIP = 'CHIP';
    case MANUAL_ENTRY = 'MANUAL_ENTRY';
    case CUSTOMER_ENTRY = 'CUSTOMER_ENTRY';
    case MAGSTRIPE_FALLBACK = 'MAGSTRIPE_FALLBACK';
    case MAGSTRIPE = 'MAGSTRIPE';
    case DIRECT_DEBIT = 'DIRECT_DEBIT';
    case CONTACTLESS = 'CONTACTLESS';
    case MOTO = 'MOTO';
    case CONTACTLESS_MAGSTRIPE = 'CONTACTLESS_MAGSTRIPE';
    case N_A = 'N/A';
}

/**
 * Type of the transaction event.
 */
enum TransactionEventEventType: string
{
    case PAYOUT = 'PAYOUT';
    case CHARGE_BACK = 'CHARGE_BACK';
    case REFUND = 'REFUND';
    case PAYOUT_DEDUCTION = 'PAYOUT_DEDUCTION';
}

/**
 * Status of the transaction event.
 */
enum TransactionEventStatus: string
{
    case PENDING = 'PENDING';
    case SCHEDULED = 'SCHEDULED';
    case FAILED = 'FAILED';
    case REFUNDED = 'REFUNDED';
    case SUCCESSFUL = 'SUCCESSFUL';
    case PAID_OUT = 'PAID_OUT';
}

/**
 * Payout plan of the registered user at the time when the transaction was made.
 */
enum TransactionMixinHistoryPayoutPlan: string
{
    case SINGLE_PAYMENT = 'SINGLE_PAYMENT';
    case TRUE_INSTALLMENT = 'TRUE_INSTALLMENT';
    case ACCELERATED_INSTALLMENT = 'ACCELERATED_INSTALLMENT';
}

/**
 * Details of the payment card.
 */
class CardResponse
{
    /**
     * Last 4 digits of the payment card number.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Issuing card network of the payment card used for the transaction.
     *
     * @var CardResponseType|null
     */
    public ?CardResponseType $type = null;

}

class Event
{
    /**
     * Unique ID of the transaction event.
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $transactionId = null;

    /**
     * Type of the transaction event.
     *
     * @var EventType|null
     */
    public ?EventType $type = null;

    /**
     * Status of the transaction event.
     *
     * @var EventStatus|null
     */
    public ?EventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Date and time of the transaction event.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Amount of the fee related to the event.
     *
     * @var float|null
     */
    public ?float $feeAmount = null;

    /**
     * Consecutive number of the installment.
     *
     * @var int|null
     */
    public ?int $installmentNumber = null;

    /**
     * Amount deducted for the event.
     *
     * @var float|null
     */
    public ?float $deductedAmount = null;

    /**
     * Amount of the fee deducted for the event.
     *
     * @var float|null
     */
    public ?float $deductedFeeAmount = null;

}

/**
 * Details of a link to a related resource.
 */
class Link
{
    /**
     * Specifies the relation to the current resource.
     *
     * @var string|null
     */
    public ?string $rel = null;

    /**
     * URL for accessing the related resource.
     *
     * @var string|null
     */
    public ?string $href = null;

    /**
     * Specifies the media type of the related resource.
     *
     * @var string|null
     */
    public ?string $type = null;

}

class LinkRefund
{
    /**
     * Specifies the relation to the current resource.
     *
     * @var string|null
     */
    public ?string $rel = null;

    /**
     * URL for accessing the related resource.
     *
     * @var string|null
     */
    public ?string $href = null;

    /**
     * Specifies the media type of the related resource.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Minimum allowed amount for the refund.
     *
     * @var float|null
     */
    public ?float $minAmount = null;

    /**
     * Maximum allowed amount for the refund.
     *
     * @var float|null
     */
    public ?float $maxAmount = null;

}

/**
 * Details of the product for which the payment is made.
 */
class Product
{
    /**
     * Name of the product from the merchant's catalog.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Price of the product without VAT.
     *
     * @var float|null
     */
    public ?float $price = null;

    /**
     * VAT rate applicable to the product.
     *
     * @var float|null
     */
    public ?float $vatRate = null;

    /**
     * Amount of the VAT for a single product item (calculated as the product of `price` and `vat_rate`, i.e. `single_vat_amount = price * vat_rate`).
     *
     * @var float|null
     */
    public ?float $singleVatAmount = null;

    /**
     * Price of a single product item with VAT.
     *
     * @var float|null
     */
    public ?float $priceWithVat = null;

    /**
     * Total VAT amount for the purchase (calculated as the product of `single_vat_amount` and `quantity`, i.e. `vat_amount = single_vat_amount * quantity`).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Number of product items for the purchase.
     *
     * @var float|null
     */
    public ?float $quantity = null;

    /**
     * Total price of the product items without VAT (calculated as the product of `price` and `quantity`, i.e. `total_price = price * quantity`).
     *
     * @var float|null
     */
    public ?float $totalPrice = null;

    /**
     * Total price of the product items including VAT (calculated as the product of `price_with_vat` and `quantity`, i.e. `total_with_vat = price_with_vat * quantity`).
     *
     * @var float|null
     */
    public ?float $totalWithVat = null;

}

/**
 * Details of a transaction event.
 */
class TransactionEvent
{
    /**
     * Unique ID of the transaction event.
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Type of the transaction event.
     *
     * @var TransactionEventEventType|null
     */
    public ?TransactionEventEventType $eventType = null;

    /**
     * Status of the transaction event.
     *
     * @var TransactionEventStatus|null
     */
    public ?TransactionEventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Date when the transaction event is due to occur.
     *
     * @var string|null
     */
    public ?string $dueDate = null;

    /**
     * Date when the transaction event occurred.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Consecutive number of the installment that is paid. Applicable only payout events, i.e. `event_type = PAYOUT`.
     *
     * @var int|null
     */
    public ?int $installmentNumber = null;

    /**
     * Date and time of the transaction event.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

}

class TransactionFull
{
    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Transaction code returned by the acquirer/processing entity after processing the transaction.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Total amount of the transaction.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Date and time of the creation of the transaction. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Current status of the transaction.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Payment type used for the transaction.
     *
     * @var string|null
     */
    public ?string $paymentType = null;

    /**
     * Current number of the installment for deferred payments.
     *
     * @var int|null
     */
    public ?int $installmentsCount = null;

    /**
     * Unique code of the registered merchant to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Amount of the applicable VAT (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Amount of the tip (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $tipAmount = null;

    /**
     * Entry mode of the payment details.
     *
     * @var string|null
     */
    public ?string $entryMode = null;

    /**
     * Authorization code for the transaction sent by the payment card issuer or bank. Applicable only to card payments.
     *
     * @var string|null
     */
    public ?string $authCode = null;

    /**
     * Internal unique ID of the transaction on the SumUp platform.
     *
     * @var int|null
     */
    public ?int $internalId = null;

    /**
     * Short description of the payment. The value is taken from the `description` property of the related checkout resource.
     *
     * @var string|null
     */
    public ?string $productSummary = null;

    /**
     * Total number of payouts to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsTotal = null;

    /**
     * Number of payouts that are made to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsReceived = null;

    /**
     * Payout plan of the registered user at the time when the transaction was made.
     *
     * @var string|null
     */
    public ?string $payoutPlan = null;

    /**
     * Email address of the registered user (merchant) to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $username = null;

    /**
     * Latitude value from the coordinates of the payment location (as received from the payment terminal reader).
     *
     * @var float|null
     */
    public ?float $lat = null;

    /**
     * Longitude value from the coordinates of the payment location (as received from the payment terminal reader).
     *
     * @var float|null
     */
    public ?float $lon = null;

    /**
     * Indication of the precision of the geographical position received from the payment terminal.
     *
     * @var float|null
     */
    public ?float $horizontalAccuracy = null;

    /**
     * Simple name of the payment type.
     *
     * @var string|null
     */
    public ?string $simplePaymentType = null;

    /**
     * Verification method used for the transaction.
     *
     * @var string|null
     */
    public ?string $verificationMethod = null;

    /**
     * Details of the payment card.
     *
     * @var CardResponse|null
     */
    public ?CardResponse $card = null;

    /**
     * Local date and time of the creation of the transaction.
     *
     * @var string|null
     */
    public ?string $localTime = null;

    /**
     * Payout type for the transaction.
     *
     * @var string|null
     */
    public ?string $payoutType = null;

    /**
     * List of products from the merchant's catalogue for which the transaction serves as a payment.
     *
     * @var Product[]|null
     */
    public ?array $products = null;

    /**
     * List of VAT rates applicable to the transaction.
     *
     * @var mixed[]|null
     */
    public ?array $vatRates = null;

    /**
     * List of transaction events related to the transaction.
     *
     * @var TransactionEvent[]|null
     */
    public ?array $transactionEvents = null;

    /**
     * Status generated from the processing status and the latest transaction state.
     *
     * @var string|null
     */
    public ?string $simpleStatus = null;

    /**
     * List of hyperlinks for accessing related resources.
     *
     * @var mixed[]|null
     */
    public ?array $links = null;

    /**
     * List of events related to the transaction.
     *
     * @var Event[]|null
     */
    public ?array $events = null;

    /**
     * Details of the payment location as received from the payment terminal.
     *
     * @var array|null
     */
    public ?array $location = null;

    /**
     * Indicates whether tax deduction is enabled for the transaction.
     *
     * @var bool|null
     */
    public ?bool $taxEnabled = null;

}

class TransactionHistory
{
    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Transaction code returned by the acquirer/processing entity after processing the transaction.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Total amount of the transaction.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Date and time of the creation of the transaction. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Current status of the transaction.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Payment type used for the transaction.
     *
     * @var string|null
     */
    public ?string $paymentType = null;

    /**
     * Current number of the installment for deferred payments.
     *
     * @var int|null
     */
    public ?int $installmentsCount = null;

    /**
     * Short description of the payment. The value is taken from the `description` property of the related checkout resource.
     *
     * @var string|null
     */
    public ?string $productSummary = null;

    /**
     * Total number of payouts to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsTotal = null;

    /**
     * Number of payouts that are made to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsReceived = null;

    /**
     * Payout plan of the registered user at the time when the transaction was made.
     *
     * @var string|null
     */
    public ?string $payoutPlan = null;

    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $transactionId = null;

    /**
     * Client-specific ID of the transaction.
     *
     * @var string|null
     */
    public ?string $clientTransactionId = null;

    /**
     * Email address of the registered user (merchant) to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $user = null;

    /**
     * Type of the transaction for the registered user specified in the `user` property.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Issuing card network of the payment card used for the transaction.
     *
     * @var string|null
     */
    public ?string $cardType = null;

}

class TransactionMixinHistory
{
    /**
     * Short description of the payment. The value is taken from the `description` property of the related checkout resource.
     *
     * @var string|null
     */
    public ?string $productSummary = null;

    /**
     * Total number of payouts to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsTotal = null;

    /**
     * Number of payouts that are made to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsReceived = null;

    /**
     * Payout plan of the registered user at the time when the transaction was made.
     *
     * @var TransactionMixinHistoryPayoutPlan|null
     */
    public ?TransactionMixinHistoryPayoutPlan $payoutPlan = null;

}
