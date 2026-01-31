<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Id of the legal type of the merchant profile
 */
class LegalTypeLegacy
{
    /**
     * Unique id
     *
     * @var float|null
     */
    public ?float $id = null;

    /**
     * Legal type description
     *
     * @var string|null
     */
    public ?string $fullDescription = null;

    /**
     * Legal type short description
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Sole trader legal type if true
     *
     * @var bool|null
     */
    public ?bool $soleTrader = null;

}
