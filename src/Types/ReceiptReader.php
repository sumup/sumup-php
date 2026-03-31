<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Card reader details displayed on the receipt.
 */
class ReceiptReader
{
    /**
     * Reader serial number.
     *
     * @var string|null
     */
    public ?string $code = null;

    /**
     * Reader type.
     *
     * @var string|null
     */
    public ?string $type = null;

}
