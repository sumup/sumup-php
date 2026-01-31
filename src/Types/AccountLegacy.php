<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Profile information.
 */
class AccountLegacy
{
    /**
     * Username of the user profile.
     *
     * @var string|null
     */
    public ?string $username = null;

    /**
     * The role of the user.
     *
     * @var AccountLegacyType|null
     */
    public ?AccountLegacyType $type = null;

}
