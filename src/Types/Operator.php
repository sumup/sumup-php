<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Operator account for a merchant.
 */
class Operator
{
    /**
     *
     * @var int
     */
    public int $id;

    /**
     *
     * @var string
     */
    public string $username;

    /**
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     *
     * @var bool
     */
    public bool $disabled;

    /**
     * The timestamp of when the operator was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the operator was last updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Permissions assigned to an operator or user.
     *
     * @var Permissions
     */
    public Permissions $permissions;

    /**
     *
     * @var OperatorAccountType
     */
    public OperatorAccountType $accountType;

}
