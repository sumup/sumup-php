<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of a transaction event.
 */
class TransactionEvent
{
    /**
     * Unique ID of the transaction event.
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Type of the transaction event.
     *
     * @var TransactionEventEventType|null
     */
    public ?TransactionEventEventType $eventType = null;

    /**
     * Status of the transaction event.
     *
     * @var TransactionEventStatus|null
     */
    public ?TransactionEventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Date when the transaction event is due to occur.
     *
     * @var string|null
     */
    public ?string $dueDate = null;

    /**
     * Date when the transaction event occurred.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Consecutive number of the installment that is paid. Applicable only payout events, i.e. `event_type = PAYOUT`.
     *
     * @var int|null
     */
    public ?int $installmentNumber = null;

    /**
     * Date and time of the transaction event.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

}
