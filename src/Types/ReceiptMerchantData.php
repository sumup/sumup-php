<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Receipt merchant data
 */
class ReceiptMerchantData
{
    /**
     * Merchant profile details displayed on the receipt.
     *
     * @var ReceiptMerchantDataMerchantProfile|null
     */
    public ?ReceiptMerchantDataMerchantProfile $merchantProfile = null;

    /**
     * Locale used for rendering localized receipt fields.
     *
     * @var string|null
     */
    public ?string $locale = null;

}
