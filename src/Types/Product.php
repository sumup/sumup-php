<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the product for which the payment is made.
 */
class Product
{
    /**
     * Name of the product from the merchant's catalog.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Price of the product without VAT.
     *
     * @var float|null
     */
    public ?float $price = null;

    /**
     * VAT rate applicable to the product.
     *
     * @var float|null
     */
    public ?float $vatRate = null;

    /**
     * Amount of the VAT for a single product item (calculated as the product of `price` and `vat_rate`, i.e. `single_vat_amount = price * vat_rate`).
     *
     * @var float|null
     */
    public ?float $singleVatAmount = null;

    /**
     * Price of a single product item with VAT.
     *
     * @var float|null
     */
    public ?float $priceWithVat = null;

    /**
     * Total VAT amount for the purchase (calculated as the product of `single_vat_amount` and `quantity`, i.e. `vat_amount = single_vat_amount * quantity`).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Number of product items for the purchase.
     *
     * @var float|null
     */
    public ?float $quantity = null;

    /**
     * Total price of the product items without VAT (calculated as the product of `price` and `quantity`, i.e. `total_price = price * quantity`).
     *
     * @var float|null
     */
    public ?float $totalPrice = null;

    /**
     * Total price of the product items including VAT (calculated as the product of `price_with_vat` and `quantity`, i.e. `total_with_vat = price_with_vat * quantity`).
     *
     * @var float|null
     */
    public ?float $totalWithVat = null;

}
