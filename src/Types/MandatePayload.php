<?php

declare(strict_types=1);

namespace SumUp\Types;

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
