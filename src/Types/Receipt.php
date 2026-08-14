<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Receipt details for a transaction.
 */
class Receipt
{
    /**
     * Transaction details displayed on a receipt.
     *
     * @var ReceiptTransaction|null
     */
    public ?ReceiptTransaction $transactionData = null;

    /**
     * Merchant details displayed on a transaction receipt.
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
     * @var ReceiptAcquirerData|null
     */
    public ?ReceiptAcquirerData $acquirerData = null;

}
