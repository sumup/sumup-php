<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Mobile app settings
 */
class AppSettings
{
    /**
     * Checkout preference
     *
     * @var string|null
     */
    public ?string $checkoutPreference = null;

    /**
     * Include vat.
     *
     * @var bool|null
     */
    public ?bool $includeVat = null;

    /**
     * Manual entry tutorial.
     *
     * @var bool|null
     */
    public ?bool $manualEntryTutorial = null;

    /**
     * Mobile payment tutorial.
     *
     * @var bool|null
     */
    public ?bool $mobilePaymentTutorial = null;

    /**
     * Tax enabled.
     *
     * @var bool|null
     */
    public ?bool $taxEnabled = null;

    /**
     * Mobile payment.
     *
     * @var string|null
     */
    public ?string $mobilePayment = null;

    /**
     * Reader payment.
     *
     * @var string|null
     */
    public ?string $readerPayment = null;

    /**
     * Cash payment.
     *
     * @var string|null
     */
    public ?string $cashPayment = null;

    /**
     * Advanced mode.
     *
     * @var string|null
     */
    public ?string $advancedMode = null;

    /**
     * Expected max transaction amount.
     *
     * @var float|null
     */
    public ?float $expectedMaxTransactionAmount = null;

    /**
     * Manual entry.
     *
     * @var string|null
     */
    public ?string $manualEntry = null;

    /**
     * Terminal mode tutorial.
     *
     * @var bool|null
     */
    public ?bool $terminalModeTutorial = null;

    /**
     * Tipping.
     *
     * @var string|null
     */
    public ?string $tipping = null;

    /**
     * Tip rates.
     *
     * @var float[]|null
     */
    public ?array $tipRates = null;

    /**
     * Barcode scanner.
     *
     * @var string|null
     */
    public ?string $barcodeScanner = null;

    /**
     * Referral.
     *
     * @var string|null
     */
    public ?string $referral = null;

}
