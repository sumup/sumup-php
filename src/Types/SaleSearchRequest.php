<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Filter and pagination criteria for `POST /sales/search`. Filters from different categories
 * stack with **logical AND**; multiple values in one array field stack with **logical OR**.
 * Results cover the merchant’s **last two years** of sales (narrow further with `start_date` /
 * `end_date`). Results are sorted **newest first** by sale close date.
 */
class SaleSearchRequest
{
    /**
     * Sale created **on or after** this instant (inclusive).
     *
     * @var string|null
     */
    public ?string $startDate = null;

    /**
     * Sale created **on or before** this instant (inclusive).
     *
     * @var string|null
     */
    public ?string $endDate = null;

    /**
     * Filters rows by sale lifecycle (`state`). Multiple values match any of them (**OR**).
     * Uses the same values as `Sale.state`. Non-finalised sales are never returned; only
     * fully-paid sales.
     *
     * @var string[]|null
     */
    public ?array $saleStatuses = null;

    /**
     * Filters rows by payment outcome. Multiple values match any of them (**OR**). The search
     * row does not echo this value.
     *
     * @var string[]|null
     */
    public ?array $paymentStatuses = null;

    /**
     * Sales channel filter. Multiple values match any of them (**OR**).
     *
     * @var string[]|null
     */
    public ?array $salesChannels = null;

    /**
     * Opaque pagination token from a previous search response. Not interchangeable with tokens
     * from `GET /sales`.
     *
     * @var string|null
     */
    public ?string $paginationToken = null;

    /**
     * Maximum number of results per page.
     *
     * @var int|null
     */
    public ?int $paginationLimit = null;

    /**
     * Create request DTO.
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string[]|null $saleStatuses
     * @param string[]|null $paymentStatuses
     * @param string[]|null $salesChannels
     * @param string|null $paginationToken
     * @param int|null $paginationLimit
     */
    public function __construct(
        ?string $startDate = null,
        ?string $endDate = null,
        ?array $saleStatuses = null,
        ?array $paymentStatuses = null,
        ?array $salesChannels = null,
        ?string $paginationToken = null,
        ?int $paginationLimit = null
    ) {
        \SumUp\Hydrator::hydrate([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sale_statuses' => $saleStatuses,
            'payment_statuses' => $paymentStatuses,
            'sales_channels' => $salesChannels,
            'pagination_token' => $paginationToken,
            'pagination_limit' => $paginationLimit,
        ], self::class, $this);
    }

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $request = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        \SumUp\Hydrator::hydrate($data, self::class, $request);

        return $request;
    }

}
