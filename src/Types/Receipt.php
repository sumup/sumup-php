<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Receipt details for a transaction.
 */
class Receipt
{
    /**
     * Transaction information.
     *
     * @var ReceiptTransaction|null
     */
    public ?ReceiptTransaction $transactionData = null;

    /**
     * Receipt merchant data
     *
     * @var ReceiptMerchantData|null
     */
    public ?ReceiptMerchantData $merchantData = null;

    /**
     * EMV-specific metadata returned for card-present payments.
     *
     * @var array<string, mixed>|null
     */
    public ?array $emvData = null;

    /**
     * Acquirer-specific metadata related to the card authorization.
     *
     * @var array<string, mixed>|null
     */
    public ?array $acquirerData = null;

}
