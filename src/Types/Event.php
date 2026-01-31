<?php

declare(strict_types=1);

namespace SumUp\Types;

class Event
{
    /**
     * Unique ID of the transaction event.
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $transactionId = null;

    /**
     * Type of the transaction event.
     *
     * @var EventType|null
     */
    public ?EventType $type = null;

    /**
     * Status of the transaction event.
     *
     * @var EventStatus|null
     */
    public ?EventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Date and time of the transaction event.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Amount of the fee related to the event.
     *
     * @var float|null
     */
    public ?float $feeAmount = null;

    /**
     * Consecutive number of the installment.
     *
     * @var int|null
     */
    public ?int $installmentNumber = null;

    /**
     * Amount deducted for the event.
     *
     * @var float|null
     */
    public ?float $deductedAmount = null;

    /**
     * Amount of the fee deducted for the event.
     *
     * @var float|null
     */
    public ?float $deductedFeeAmount = null;

}
