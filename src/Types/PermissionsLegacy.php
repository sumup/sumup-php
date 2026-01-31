<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * User permissions
 */
class PermissionsLegacy
{
    /**
     * Create MOTO payments
     *
     * @var bool|null
     */
    public ?bool $createMotoPayments = null;

    /**
     * Can view full merchant transaction history
     *
     * @var bool|null
     */
    public ?bool $fullTransactionHistoryView = null;

    /**
     * Refund transactions
     *
     * @var bool|null
     */
    public ?bool $refundTransactions = null;

    /**
     * Create referral
     *
     * @var bool|null
     */
    public ?bool $createReferral = null;

}
