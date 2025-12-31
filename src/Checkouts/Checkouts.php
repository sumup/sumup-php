<?php

declare(strict_types=1);

namespace SumUp\Checkouts;

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

/**
 * Issuing card network of the payment card used for the transaction.
 */
enum CardType: string
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
 * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
 */
enum CheckoutCreateRequestCurrency: string
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
 * Purpose of the checkout.
 */
enum CheckoutCreateRequestPurpose: string
{
    case CHECKOUT = 'CHECKOUT';
    case SETUP_RECURRING_PAYMENT = 'SETUP_RECURRING_PAYMENT';
}

/**
 * Current status of the checkout.
 */
enum CheckoutCreateRequestStatus: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case PAID = 'PAID';
}

/**
 * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
 */
enum CheckoutCurrency: string
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
 * Current status of the checkout.
 */
enum CheckoutStatus: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case PAID = 'PAID';
    case EXPIRED = 'EXPIRED';
}

/**
 * Indicates the mandate type
 */
enum MandatePayloadType: string
{
    case RECURRENT = 'recurrent';
}

/**
 * Describes the payment method used to attempt processing
 */
enum ProcessCheckoutPaymentType: string
{
    case CARD = 'card';
    case BOLETO = 'boleto';
    case IDEAL = 'ideal';
    case BLIK = 'blik';
    case BANCONTACT = 'bancontact';
}

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

/**
 * Details of the payment checkout.
 */
class Checkout
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string|null
     */
    public ?string $checkoutReference = null;

    /**
     * Amount of the payment.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var CheckoutCurrency|null
     */
    public ?CheckoutCurrency $currency = null;

    /**
     * Unique identifying code of the merchant profile.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Short description of the checkout visible in the SumUp dashboard. The description can contribute to reporting, allowing easier identification of a checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * URL to which the SumUp platform sends the processing status of the payment checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Unique ID of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current status of the checkout.
     *
     * @var CheckoutStatus|null
     */
    public ?CheckoutStatus $status = null;

    /**
     * Date and time of the creation of the payment checkout. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Created mandate
     *
     * @var \SumUp\Shared\MandateResponse|null
     */
    public ?\SumUp\Shared\MandateResponse $mandate = null;

    /**
     * List of transactions related to the payment.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

}

/**
 * 3DS Response
 */
class CheckoutAccepted
{
    /**
     * Required action processing 3D Secure payments.
     *
     * @var array|null
     */
    public ?array $nextStep = null;

}

/**
 * Details of the payment checkout.
 */
class CheckoutCreateRequest
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string
     */
    public string $checkoutReference;

    /**
     * Amount of the payment.
     *
     * @var float
     */
    public float $amount;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var CheckoutCreateRequestCurrency
     */
    public CheckoutCreateRequestCurrency $currency;

    /**
     * Unique identifying code of the merchant profile.
     *
     * @var string
     */
    public string $merchantCode;

    /**
     * Short description of the checkout visible in the SumUp dashboard. The description can contribute to reporting, allowing easier identification of a checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * URL to which the SumUp platform sends the processing status of the payment checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Purpose of the checkout.
     *
     * @var CheckoutCreateRequestPurpose|null
     */
    public ?CheckoutCreateRequestPurpose $purpose = null;

    /**
     * Unique ID of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current status of the checkout.
     *
     * @var CheckoutCreateRequestStatus|null
     */
    public ?CheckoutCreateRequestStatus $status = null;

    /**
     * Date and time of the creation of the payment checkout. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * List of transactions related to the payment.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

    /**
     * __Required__ for [APMs](https://developer.sumup.com/online-payments/apm/introduction) and __recommended__ for card payments. Refers to a url where the end user is redirected once the payment processing completes. If not specified, the [Payment Widget](https://developer.sumup.com/online-payments/tools/card-widget) renders [3DS challenge](https://developer.sumup.com/online-payments/features/3ds) within an iframe instead of performing a full-page redirect.
     *
     * @var string|null
     */
    public ?string $redirectUrl = null;

}

class CheckoutSuccess
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string|null
     */
    public ?string $checkoutReference = null;

    /**
     * Amount of the payment.
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
     * Unique identifying code of the merchant profile.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Short description of the checkout visible in the SumUp dashboard. The description can contribute to reporting, allowing easier identification of a checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * URL to which the SumUp platform sends the processing status of the payment checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Unique ID of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current status of the checkout.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Date and time of the creation of the payment checkout. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Created mandate
     *
     * @var \SumUp\Shared\MandateResponse|null
     */
    public ?\SumUp\Shared\MandateResponse $mandate = null;

    /**
     * List of transactions related to the payment.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

    /**
     * Transaction code of the successful transaction with which the payment for the checkout is completed.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Transaction ID of the successful transaction with which the payment for the checkout is completed.
     *
     * @var string|null
     */
    public ?string $transactionId = null;

    /**
     * Name of the merchant
     *
     * @var string|null
     */
    public ?string $merchantName = null;

    /**
     * Refers to a url where the end user is redirected once the payment processing completes.
     *
     * @var string|null
     */
    public ?string $redirectUrl = null;

    /**
     * Object containing token information for the specified payment instrument
     *
     * @var array|null
     */
    public ?array $paymentInstrument = null;

}

/**
 * Error message structure.
 */
class DetailsError
{
    /**
     * Short title of the error.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * Details of the error.
     *
     * @var string|null
     */
    public ?string $details = null;

    /**
     * The status code.
     *
     * @var float|null
     */
    public ?float $status = null;

    /**
     *
     * @var array[]|null
     */
    public ?array $failedConstraints = null;

}

class ErrorExtended
{
    /**
     * Short description of the error.
     *
     * @var string|null
     */
    public ?string $message = null;

    /**
     * Platform code for the error.
     *
     * @var string|null
     */
    public ?string $errorCode = null;

    /**
     * Parameter name (with relative location) to which the error applies. Parameters from embedded resources are displayed using dot notation. For example, `card.name` refers to the `name` parameter embedded in the `card` object.
     *
     * @var string|null
     */
    public ?string $param = null;

}

/**
 * Mandate is passed when a card is to be tokenized
 */
class MandatePayload
{
    /**
     * Indicates the mandate type
     *
     * @var MandatePayloadType
     */
    public MandatePayloadType $type;

    /**
     * Operating system and web client used by the end-user
     *
     * @var string
     */
    public string $userAgent;

    /**
     * IP address of the end user. Supports IPv4 and IPv6
     *
     * @var string|null
     */
    public ?string $userIp = null;

}

/**
 * Details of the payment instrument for processing the checkout.
 */
class ProcessCheckout
{
    /**
     * Describes the payment method used to attempt processing
     *
     * @var ProcessCheckoutPaymentType
     */
    public ProcessCheckoutPaymentType $paymentType;

    /**
     * Number of installments for deferred payments. Available only to merchant users in Brazil.
     *
     * @var int|null
     */
    public ?int $installments = null;

    /**
     * Mandate is passed when a card is to be tokenized
     *
     * @var MandatePayload|null
     */
    public ?MandatePayload $mandate = null;

    /**
     * __Required when payment type is `card`.__ Details of the payment card.
     *
     * @var Card|null
     */
    public ?Card $card = null;

    /**
     * __Required when using a tokenized card to process a checkout.__ Unique token identifying the saved payment card for a customer.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * __Required when `token` is provided.__ Unique ID of the customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Personal details for the customer.
     *
     * @var \SumUp\Shared\PersonalDetails|null
     */
    public ?\SumUp\Shared\PersonalDetails $personalDetails = null;

}


namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Checkouts
 *
 * @package SumUp\Services
 */
class Checkouts implements SumUpService
{
    /**
     * The client for the http communication.
     *
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Checkouts constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Create a checkout
     *
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Checkouts\Checkout
     */
    public function create($body = null)
    {
        $path = '/v0.1/checkouts';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Checkouts\Checkout::class],
        ]);
    }

    /**
     * Deactivate a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\Checkouts\Checkout
     */
    public function deactivate($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Checkouts\Checkout::class);
    }

    /**
     * Retrieve a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\Checkouts\CheckoutSuccess
     */
    public function get($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Checkouts\CheckoutSuccess::class);
    }

    /**
     * List checkouts
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Checkouts\CheckoutSuccess[]
     */
    public function list($queryParams = [])
    {
        $path = '/v0.1/checkouts';
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutSuccess::class]],
        ]);
    }

    /**
     * Get available payment methods
     *
     * @param string $merchantCode The SumUp merchant code.
     * @param array $queryParams Optional query string parameters
     *
     * @return array
     */
    public function listAvailablePaymentMethods($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v0.1/merchants/%s/payment-methods', rawurlencode((string) $merchantCode));
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Process a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Checkouts\CheckoutSuccess|\SumUp\Checkouts\CheckoutAccepted
     */
    public function process($id, $body = null)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutSuccess::class],
            '202' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutAccepted::class],
        ]);
    }
}
