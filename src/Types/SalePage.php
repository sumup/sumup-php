<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Paginated list of `Sale` objects. Results are ordered **newest first** by the newest
 * activity recorded for each sale. See `ListSalesV10`.
 */
class SalePage
{
    /**
     *
     * @var Sale[]
     */
    public array $items;

    /**
     * Pagination token for subsequent requests. Should only be set by clients if they have
     * received a token in the previous response, and this request is an immediate follow-up
     * request to that response to load the subsequent page. Clients should treat this as an
     * opaque token and should not attempt to parse it in any way.
     *
     * @var string|null
     */
    public ?string $paginationToken = null;

}
