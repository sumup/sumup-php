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
     * Opaque token for the next page. Pass it as `pagination_token` in the next search
     * request body with the same filters. Omitted when no further page is available.
     *
     * @var string|null
     */
    public ?string $paginationToken = null;

}
