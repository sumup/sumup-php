<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Search hits and an optional pagination token. Results are ordered **newest first** by sale close date.
 */
class SaleSearchResponse
{
    /**
     *
     * @var SaleSearchItem[]
     */
    public array $items;

    /**
     * Opaque token for the next page of search results.
     *
     * @var string|null
     */
    public ?string $paginationToken = null;

}
