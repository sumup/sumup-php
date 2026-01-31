<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Permissions assigned to an operator or user.
 */
class Permissions
{
    /**
     *
     * @var bool
     */
    public bool $createMotoPayments;

    /**
     *
     * @var bool
     */
    public bool $createReferral;

    /**
     *
     * @var bool
     */
    public bool $fullTransactionHistoryView;

    /**
     *
     * @var bool
     */
    public bool $refundTransactions;

    /**
     *
     * @var bool
     */
    public bool $admin;

}
