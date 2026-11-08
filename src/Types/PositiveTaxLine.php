<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Tax line with positive amounts only.
 * Information about tax together with amounts before and after its application such as:
 * - net amount: taxable net amount, scoped by this tax
 * - gross amount: amount after applying the tax
 * The numbers here can't be negative.
 */
class PositiveTaxLine
{
    /**
     * Tax ID from the Tax Service (External Id)
     *
     * @var string
     */
    public string $id;

    /**
     * Tax name, e.g. "MwSt."
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The tax rate percentage in minor units (1/100000). For example 19000 = 19%.
     *
     * @var int|null
     */
    public ?int $percentage = null;

    /**
     * Net amount before applying the tax.
     * The value of the amount in minor units of the currency according to the Sale.currency.scale.
     *
     * @var int
     */
    public int $netAmount;

    /**
     * Gross amount after applying the tax.
     * The value of the amount in minor units of the currency according to the Sale.currency.scale.
     *
     * @var int
     */
    public int $grossAmount;

    /**
     * Amount of tax.
     * The value of the amount in minor units of the currency according to the Sale.currency.scale.
     *
     * @var int
     */
    public int $taxAmount;

}
