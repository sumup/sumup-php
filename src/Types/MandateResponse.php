<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Created mandate
 */
class MandateResponse
{
    /**
     * Indicates the mandate type
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Mandate status
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Merchant code which has the mandate
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

}
