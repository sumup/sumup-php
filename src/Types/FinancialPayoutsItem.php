<?php

declare(strict_types=1);

namespace SumUp\Types;

class FinancialPayoutsItem
{
    /**
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     *
     * @var float|null
     */
    public ?float $fee = null;

    /**
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     *
     * @var string|null
     */
    public ?string $reference = null;

    /**
     *
     * @var FinancialPayoutsItemStatus|null
     */
    public ?FinancialPayoutsItemStatus $status = null;

    /**
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     *
     * @var FinancialPayoutsItemType|null
     */
    public ?FinancialPayoutsItemType $type = null;

}
