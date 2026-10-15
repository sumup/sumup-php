<?php

declare(strict_types=1);

namespace SumUp\Types;

class BadRequestErrors
{
    /**
     * Fuller message giving context to error
     *
     * @var string|null
     */
    public ?string $detail = null;

    /**
     * Key indicating type of error
     *
     * @var BadRequestErrorsType|string
     */
    public BadRequestErrorsType|string $type;

}
