<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Account's merchant profile
 */
class MerchantProfileLegacy
{
    /**
     * Unique identifying code of the merchant profile
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Company name
     *
     * @var string|null
     */
    public ?string $companyName = null;

    /**
     * Website
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * Id of the legal type of the merchant profile
     *
     * @var LegalTypeLegacy|null
     */
    public ?LegalTypeLegacy $legalType = null;

    /**
     * Merchant category code
     *
     * @var string|null
     */
    public ?string $merchantCategoryCode = null;

    /**
     * Mobile phone number
     *
     * @var string|null
     */
    public ?string $mobilePhone = null;

    /**
     * Company registration number
     *
     * @var string|null
     */
    public ?string $companyRegistrationNumber = null;

    /**
     * Vat ID
     *
     * @var string|null
     */
    public ?string $vatId = null;

    /**
     * Permanent certificate access code &#40;Portugal&#41;
     *
     * @var string|null
     */
    public ?string $permanentCertificateAccessCode = null;

    /**
     * Nature and purpose of the business
     *
     * @var string|null
     */
    public ?string $natureAndPurpose = null;

    /**
     * Details of the registered address.
     *
     * @var AddressWithDetails|null
     */
    public ?AddressWithDetails $address = null;

    /**
     * Business owners information.
     *
     * @var array[]|null
     */
    public ?array $businessOwners = null;

    /**
     * Doing Business As information
     *
     * @var DoingBusinessAsLegacy|null
     */
    public ?DoingBusinessAsLegacy $doingBusinessAs = null;

    /**
     * Merchant settings &#40;like \"payout_type\", \"payout_period\"&#41;
     *
     * @var MerchantSettings|null
     */
    public ?MerchantSettings $settings = null;

    /**
     * Merchant VAT rates
     *
     * @var VatRates|null
     */
    public ?VatRates $vatRates = null;

    /**
     * Merchant locale &#40;for internal usage only&#41;
     *
     * @var string|null
     */
    public ?string $locale = null;

    /**
     *
     * @var BankAccount[]|null
     */
    public ?array $bankAccounts = null;

    /**
     * True if the merchant is extdev
     *
     * @var bool|null
     */
    public ?bool $extdev = null;

    /**
     * True if the payout zone of this merchant is migrated
     *
     * @var bool|null
     */
    public ?bool $payoutZoneMigrated = null;

    /**
     * Merchant country code formatted according to [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) &#40;for internal usage only&#41;
     *
     * @var string|null
     */
    public ?string $country = null;

}
