<?php

declare(strict_types=1);

namespace SumUp\Types;

class BankAccount
{
    /**
     * Bank code
     *
     * @var string|null
     */
    public ?string $bankCode = null;

    /**
     * Branch code
     *
     * @var string|null
     */
    public ?string $branchCode = null;

    /**
     * SWIFT code
     *
     * @var string|null
     */
    public ?string $swift = null;

    /**
     * Account number
     *
     * @var string|null
     */
    public ?string $accountNumber = null;

    /**
     * IBAN
     *
     * @var string|null
     */
    public ?string $iban = null;

    /**
     * Type of the account
     *
     * @var string|null
     */
    public ?string $accountType = null;

    /**
     * Account category - business or personal
     *
     * @var string|null
     */
    public ?string $accountCategory = null;

    /**
     *
     * @var string|null
     */
    public ?string $accountHolderName = null;

    /**
     * Status in the verification process
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * The primary bank account is the one used for payouts
     *
     * @var bool|null
     */
    public ?bool $primary = null;

    /**
     * Creation date of the bank account
     *
     * @var string|null
     */
    public ?string $createdAt = null;

    /**
     * Bank name
     *
     * @var string|null
     */
    public ?string $bankName = null;

}
