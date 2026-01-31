<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Merchant settings &#40;like \"payout_type\", \"payout_period\"&#41;
 */
class MerchantSettings
{
    /**
     * Whether to show tax in receipts &#40;saved per transaction&#41;
     *
     * @var bool|null
     */
    public ?bool $taxEnabled = null;

    /**
     * Payout type
     *
     * @var string|null
     */
    public ?string $payoutType = null;

    /**
     * Payout frequency
     *
     * @var string|null
     */
    public ?string $payoutPeriod = null;

    /**
     * Whether merchant can edit payouts on demand
     *
     * @var bool|null
     */
    public ?bool $payoutOnDemandAvailable = null;

    /**
     * Whether merchant will receive payouts on demand
     *
     * @var bool|null
     */
    public ?bool $payoutOnDemand = null;

    /**
     * Whether to show printers in mobile app
     *
     * @var bool|null
     */
    public ?bool $printersEnabled = null;

    /**
     * Payout Instrument
     *
     * @var string|null
     */
    public ?string $payoutInstrument = null;

    /**
     * Whether merchant can make MOTO payments
     *
     * @var MerchantSettingsMotoPayment|null
     */
    public ?MerchantSettingsMotoPayment $motoPayment = null;

    /**
     * Stone merchant code
     *
     * @var string|null
     */
    public ?string $stoneMerchantCode = null;

    /**
     * Whether merchant will receive daily payout emails
     *
     * @var bool|null
     */
    public ?bool $dailyPayoutEmail = null;

    /**
     * Whether merchant will receive monthly payout emails
     *
     * @var bool|null
     */
    public ?bool $monthlyPayoutEmail = null;

    /**
     * Whether merchant has gross settlement enabled
     *
     * @var bool|null
     */
    public ?bool $grossSettlement = null;

}
