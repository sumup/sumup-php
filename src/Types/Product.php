<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Purchase product.
 */
class Product
{
    /**
     * Product name.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Product description.
     *
     * @var string|null
     */
    public ?string $priceLabel = null;

    /**
     * Product price.
     *
     * @var float|null
     */
    public ?float $price = null;

    /**
     * VAT percentage.
     *
     * @var float|null
     */
    public ?float $vatRate = null;

    /**
     * VAT amount for a single product.
     *
     * @var float|null
     */
    public ?float $singleVatAmount = null;

    /**
     * Product price incl. VAT.
     *
     * @var float|null
     */
    public ?float $priceWithVat = null;

    /**
     * VAT amount.
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Product quantity.
     *
     * @var int|null
     */
    public ?int $quantity = null;

    /**
     * Quantity x product price.
     *
     * @var float|null
     */
    public ?float $totalPrice = null;

    /**
     * Total price incl. VAT.
     *
     * @var float|null
     */
    public ?float $totalWithVat = null;

}
