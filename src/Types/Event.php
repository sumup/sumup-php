<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * High-level transaction event details.
 */
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
     * Not every value is used for every event type.
     * - `PENDING`: The event has been created but is not final yet. Used for events that are still being processed and whose final outcome is not known yet.
     * - `SCHEDULED`: The event is planned for a future payout cycle but has not been executed yet. This applies to payout events before money is actually sent out.
     * - `RECONCILED`: The underlying payment has been matched with settlement data and is ready to continue through payout processing, but the funds have not been paid out yet. This applies to payout events.
     * - `PAID_OUT`: The payout event has been completed and the funds were included in a merchant payout.
     * - `REFUNDED`: A refund event has been accepted and recorded in the refund flow. This is the status returned for refund events once the transaction amount is being or has been returned to the payer.
     * - `SUCCESSFUL`: The event completed successfully. Use this as the generic terminal success status for event types that do not expose a more specific business outcome such as `PAID_OUT` or `REFUNDED`.
     * - `FAILED`: The event could not be completed. Typical examples are a payout that could not be executed or an event that was rejected during processing.
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
