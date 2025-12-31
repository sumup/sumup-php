<?php

declare(strict_types=1);

namespace SumUp\Readers;

/**
 * The card type of the card used for the transaction.
 * Is is required only for some countries (e.g: Brazil).
 *
 */
enum CreateReaderCheckoutRequestCardType: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
}

/**
 * Type of connection used by the device
 */
enum ModelConnectionType: string
{
    case BTLE = 'btle';
    case EDGE = 'edge';
    case GPRS = 'gprs';
    case LTE = 'lte';
    case UMTS = 'umts';
    case USB = 'usb';
    case WI_FI = 'Wi-Fi';
}

/**
 * Latest state of the device
 */
enum ModelState: string
{
    case IDLE = 'IDLE';
    case SELECTING_TIP = 'SELECTING_TIP';
    case WAITING_FOR_CARD = 'WAITING_FOR_CARD';
    case WAITING_FOR_PIN = 'WAITING_FOR_PIN';
    case WAITING_FOR_SIGNATURE = 'WAITING_FOR_SIGNATURE';
    case UPDATING_FIRMWARE = 'UPDATING_FIRMWARE';
}

/**
 * Status of a device
 */
enum ModelStatus: string
{
    case ONLINE = 'ONLINE';
    case OFFLINE = 'OFFLINE';
}

/**
 * Identifier of the model of the device.
 */
enum ReaderDeviceModel: string
{
    case SOLO = 'solo';
    case VIRTUAL_SOLO = 'virtual-solo';
}

/**
 * The status of the reader object gives information about the current state of the reader.
 *
 * Possible values:
 *
 * - `unknown` - The reader status is unknown.
 * - `processing` - The reader is created and waits for the physical device to confirm the pairing.
 * - `paired` - The reader is paired with a merchant account and can be used with SumUp APIs.
 * - `expired` - The pairing is expired and no longer usable with the account. The resource needs to get recreated.
 */
enum ReaderStatus: string
{
    case UNKNOWN = 'unknown';
    case PROCESSING = 'processing';
    case PAIRED = 'paired';
    case EXPIRED = 'expired';
}

/**
 * 502 Bad Gateway
 */
class BadGateway
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * 400 Bad Request
 */
class BadRequest
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Error description
 */
class CreateReaderCheckoutError
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Reader Checkout
 */
class CreateReaderCheckoutRequest
{
    /**
     * Affiliate metadata for the transaction.
     * It is a field that allow for integrators to track the source of the transaction.
     *
     * @var array|null
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
     * @var array
     */
    public array $totalAmount;

}

class CreateReaderCheckoutResponse
{
    /**
     *
     * @var array
     */
    public array $data;

}

/**
 * Unprocessable entity
 */
class CreateReaderCheckoutUnprocessableEntity
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Error description
 */
class CreateReaderTerminateError
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Unprocessable entity
 */
class CreateReaderTerminateUnprocessableEntity
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * 504 Gateway Timeout
 */
class GatewayTimeout
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * 500 Internal Server Error
 */
class InternalServerError
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * 404 Not Found
 */
class NotFound
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * A physical card reader device that can accept in-person payments.
 */
class Reader
{
    /**
     * Unique identifier of the object.
     * Note that this identifies the instance of the physical devices pairing with your SumUp account. If you [delete](https://developer.sumup.com/api/readers/delete-reader) a reader, and pair the device again, the ID will be different. Do not use this ID to refer to a physical device.
     *
     * @var string
     */
    public string $id;

    /**
     * Custom human-readable, user-defined name for easier identification of the reader.
     *
     * @var string
     */
    public string $name;

    /**
     * The status of the reader object gives information about the current state of the reader.
     * Possible values:
     * - `unknown` - The reader status is unknown.
     * - `processing` - The reader is created and waits for the physical device to confirm the pairing.
     * - `paired` - The reader is paired with a merchant account and can be used with SumUp APIs.
     * - `expired` - The pairing is expired and no longer usable with the account. The resource needs to get recreated.
     *
     * @var ReaderStatus
     */
    public ReaderStatus $status;

    /**
     * Information about the underlying physical device.
     *
     * @var ReaderDevice
     */
    public ReaderDevice $device;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

    /**
     * The timestamp of when the reader was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the reader was last updated.
     *
     * @var string
     */
    public string $updatedAt;

}

/**
 * Information about the underlying physical device.
 */
class ReaderDevice
{
    /**
     * A unique identifier of the physical device (e.g. serial number).
     *
     * @var string
     */
    public string $identifier;

    /**
     * Identifier of the model of the device.
     *
     * @var ReaderDeviceModel
     */
    public ReaderDeviceModel $model;

}

/**
 * Status of a device
 */
class StatusResponse
{
    /**
     *
     * @var array
     */
    public array $data;

}

/**
 * 401 Unauthorized
 */
class Unauthorized
{
    /**
     *
     * @var array
     */
    public array $errors;

}


namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Readers
 *
 * @package SumUp\Services
 */
class Readers implements SumUpService
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
     * Readers constructor.
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
     * Create a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Readers\Reader
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Readers\Reader::class],
        ]);
    }

    /**
     * Create a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Readers\CreateReaderCheckoutResponse
     */
    public function createCheckout($merchantCode, $readerId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/checkout', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Readers\CreateReaderCheckoutResponse::class],
        ]);
    }

    /**
     * Delete a reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     *
     * @return null
     */
    public function delete($merchantCode, $id)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     *
     * @return \SumUp\Readers\Reader
     */
    public function get($merchantCode, $id)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Readers\Reader::class);
    }

    /**
     * Get a Reader Status
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     *
     * @return \SumUp\Readers\StatusResponse
     */
    public function getStatus($merchantCode, $readerId)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/status', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Readers\StatusResponse::class);
    }

    /**
     * List Readers
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     *
     * @return array
     */
    public function list($merchantCode)
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Terminate a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     *
     * @return null
     */
    public function terminateCheckout($merchantCode, $readerId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/terminate', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '202' => ['type' => 'void'],
        ]);
    }

    /**
     * Update a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Readers\Reader
     */
    public function update($merchantCode, $id, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PATCH', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Readers\Reader::class);
    }
}
