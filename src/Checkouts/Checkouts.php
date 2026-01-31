<?php

declare(strict_types=1);

namespace SumUp\Checkouts;

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
     * @return \SumUp\Types\Checkout
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
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Checkout::class],
        ]);
    }

    /**
     * Deactivate a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\Types\Checkout
     */
    public function deactivate($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Checkout::class);
    }

    /**
     * Retrieve a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\Types\CheckoutSuccess
     */
    public function get($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\CheckoutSuccess::class);
    }

    /**
     * List checkouts
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\CheckoutSuccess[]
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
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Types\CheckoutSuccess::class]],
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
     * @return \SumUp\Types\CheckoutSuccess|\SumUp\Types\CheckoutAccepted
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
            '200' => ['type' => 'class', 'class' => \SumUp\Types\CheckoutSuccess::class],
            '202' => ['type' => 'class', 'class' => \SumUp\Types\CheckoutAccepted::class],
        ]);
    }
}
