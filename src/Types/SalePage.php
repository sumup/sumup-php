<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Paginated list of `Sale` objects. Results are ordered **newest first** by the newest
 * activity recorded for each sale.
 */
class SalePage
{
    /**
     *
     * @var Sale[]
     */
    public array $items;

    /**
     * Opaque token for the next page. Pass it as the `pagination_token` query parameter
     * on the next list request. Omitted when no further page is available.
     *
     * @var string|null
     */
    public ?string $paginationToken = null;

}
