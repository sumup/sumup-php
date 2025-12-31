<?php

declare(strict_types=1);

namespace SumUp\Members;

/**
 * The status of the membership.
 */
enum MemberStatus: string
{
    case ACCEPTED = 'accepted';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case DISABLED = 'disabled';
    case UNKNOWN = 'unknown';
}

/**
 * A member is user within specific resource identified by resource id, resource type, and associated roles.
 */
class Member
{
    /**
     * ID of the member.
     *
     * @var string
     */
    public string $id;

    /**
     * User's roles.
     *
     * @var string[]
     */
    public array $roles;

    /**
     * User's permissions.
     *
     * @var string[]
     */
    public array $permissions;

    /**
     * The timestamp of when the member was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the member was last updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Information about the user associated with the membership.
     *
     * @var MembershipUser|null
     */
    public ?MembershipUser $user = null;

    /**
     * Pending invitation for membership.
     *
     * @var \SumUp\Shared\Invite|null
     */
    public ?\SumUp\Shared\Invite $invite = null;

    /**
     * The status of the membership.
     *
     * @var MemberStatus
     */
    public MemberStatus $status;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var array|null
     */
    public ?array $attributes = null;

}

/**
 * Information about the user associated with the membership.
 */
class MembershipUser
{
    /**
     * Identifier for the End-User (also called Subject).
     *
     * @var string
     */
    public string $id;

    /**
     * End-User's preferred e-mail address. Its value MUST conform to the RFC 5322 [RFC5322] addr-spec syntax. The RP MUST NOT rely upon this value being unique, for unique identification use ID instead.
     *
     * @var string
     */
    public string $email;

    /**
     * True if the user has enabled MFA on login.
     *
     * @var bool
     */
    public bool $mfaOnLoginEnabled;

    /**
     * True if the user is a virtual user (operator).
     *
     * @var bool
     */
    public bool $virtualUser;

    /**
     * True if the user is a service account.
     *
     * @var bool
     */
    public bool $serviceAccountUser;

    /**
     * Time when the user has been disabled. Applies only to virtual users (`virtual_user: true`).
     *
     * @var string|null
     */
    public ?string $disabledAt = null;

    /**
     * User's preferred name. Used for display purposes only.
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     * URL of the End-User's profile picture. This URL refers to an image file (for example, a PNG, JPEG, or GIF image file), rather than to a Web page containing an image.
     *
     * @var string|null
     */
    public ?string $picture = null;

    /**
     * Classic identifiers of the user.
     *
     * @var MembershipUserClassic|null
     */
    public ?MembershipUserClassic $classic = null;

}

/**
 * Classic identifiers of the user.
 */
class MembershipUserClassic
{
    /**
     *
     * @var int
     */
    public int $userId;

}


namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Members
 *
 * @package SumUp\Services
 */
class Members implements SumUpService
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
     * Members constructor.
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
     * Create a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Members\Member
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Members\Member::class],
        ]);
    }

    /**
     * Delete a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     *
     * @return null
     */
    public function delete($merchantCode, $memberId)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     *
     * @return \SumUp\Members\Member
     */
    public function get($merchantCode, $memberId)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Members\Member::class);
    }

    /**
     * List members
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array $queryParams Optional query string parameters
     *
     * @return array
     */
    public function list($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
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
     * Update a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Members\Member
     */
    public function update($merchantCode, $memberId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Members\Member::class);
    }
}
