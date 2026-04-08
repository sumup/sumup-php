<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Merchant profile details displayed on the receipt.
 */
class ReceiptMerchantDataMerchantProfile
{
    /**
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     *
     * @var string|null
     */
    public ?string $businessName = null;

    /**
     *
     * @var string|null
     */
    public ?string $companyRegistrationNumber = null;

    /**
     *
     * @var string|null
     */
    public ?string $vatId = null;

    /**
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     *
     * @var string|null
     */
    public ?string $language = null;

    /**
     *
     * @var ReceiptMerchantDataMerchantProfileAddress|null
     */
    public ?ReceiptMerchantDataMerchantProfileAddress $address = null;

}
