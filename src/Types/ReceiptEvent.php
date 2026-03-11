<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Transaction event details as rendered on the receipt.
 */
class ReceiptEvent
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
     * @var ReceiptEventType|null
     */
    public ?ReceiptEventType $type = null;

    /**
     * Status of the transaction event.
     *
     * @var ReceiptEventStatus|null
     */
    public ?ReceiptEventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var string|null
     */
    public ?string $amount = null;

    /**
     * Date and time of the transaction event.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Receipt number associated with the event.
     *
     * @var string|null
     */
    public ?string $receiptNo = null;

}
