<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Acquirer-specific metadata related to the card authorization.
 */
class ReceiptAcquirerData
{
    /**
     *
     * @var string|null
     */
    public ?string $tid = null;

    /**
     *
     * @var string|null
     */
    public ?string $authorizationCode = null;

    /**
     *
     * @var string|null
     */
    public ?string $returnCode = null;

    /**
     *
     * @var string|null
     */
    public ?string $localTime = null;

}
