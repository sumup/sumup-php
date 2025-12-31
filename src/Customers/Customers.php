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


namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Customers
 *
 * @package SumUp\Services
 */
class Customers implements SumUpService
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
     * Customers constructor.
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
     * Create a customer
     *
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Customers\Customer
     */
    public function create($body = null)
    {
        $path = '/v0.1/customers';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Customers\Customer::class],
        ]);
    }

    /**
     * Deactivate a payment instrument
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param string $token Unique token identifying the card saved as a payment instrument resource.
     *
     * @return null
     */
    public function deactivatePaymentInstrument($customerId, $token)
    {
        $path = sprintf('/v0.1/customers/%s/payment-instruments/%s', rawurlencode((string) $customerId), rawurlencode((string) $token));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '204' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a customer
     *
     * @param string $customerId Unique ID of the saved customer resource.
     *
     * @return \SumUp\Customers\Customer
     */
    public function get($customerId)
    {
        $path = sprintf('/v0.1/customers/%s', rawurlencode((string) $customerId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Customers\Customer::class);
    }

    /**
     * List payment instruments
     *
     * @param string $customerId Unique ID of the saved customer resource.
     *
     * @return \SumUp\Customers\PaymentInstrumentResponse[]
     */
    public function listPaymentInstruments($customerId)
    {
        $path = sprintf('/v0.1/customers/%s/payment-instruments', rawurlencode((string) $customerId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Customers\PaymentInstrumentResponse::class]],
        ]);
    }

    /**
     * Update a customer
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Customers\Customer
     */
    public function update($customerId, $body = null)
    {
        $path = sprintf('/v0.1/customers/%s', rawurlencode((string) $customerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Customers\Customer::class);
    }
}
