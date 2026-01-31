<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the merchant account.
 */
class MerchantAccount
{
    /**
     * Profile information.
     *
     * @var AccountLegacy|null
     */
    public ?AccountLegacy $account = null;

    /**
     * Account's personal profile.
     *
     * @var PersonalProfileLegacy|null
     */
    public ?PersonalProfileLegacy $personalProfile = null;

    /**
     * Account's merchant profile
     *
     * @var MerchantProfileLegacy|null
     */
    public ?MerchantProfileLegacy $merchantProfile = null;

    /**
     * Mobile app settings
     *
     * @var AppSettings|null
     */
    public ?AppSettings $appSettings = null;

    /**
     * User permissions
     *
     * @var PermissionsLegacy|null
     */
    public ?PermissionsLegacy $permissions = null;

}
