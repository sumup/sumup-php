<?php

declare(strict_types=1);

namespace SumUp\Types;

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
     *
     * @var array<string, mixed>|null
     */
    public ?array $emvData = null;

    /**
     *
     * @var array<string, mixed>|null
     */
    public ?array $acquirerData = null;

}
