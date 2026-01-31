<?php

declare(strict_types=1);

namespace SumUp\Types;

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
     *
     * @var string|null
     */
    public ?string $receiptNo = null;

}
