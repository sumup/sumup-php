<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Information about the company or business. This is legal information that is used for verification.
 *
 */
class Company
{
    /**
     * The company's legal name.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The merchant category code for the account as specified by [ISO18245](https://www.iso.org/standard/33365.html). MCCs are used to classify businesses based on the goods or services they provide.
     *
     * @var string|null
     */
    public ?string $merchantCategoryCode = null;

    /**
     * The unique legal type reference as defined in the country SDK. We do not rely on IDs as used by other services. Consumers of this API are expected to use the country SDK to map to any other IDs, translation keys, or descriptions.
     *
     * @var string|null
     */
    public ?string $legalType = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $address = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $tradingAddress = null;

    /**
     * A list of country-specific company identifiers.
     *
     * @var CompanyIdentifier[]|null
     */
    public ?array $identifiers = null;

    /**
     * A publicly available phone number in [E.164](https://en.wikipedia.org/wiki/E.164) format.
     *
     * @var string|null
     */
    public ?string $phoneNumber = null;

    /**
     * HTTP(S) URL of the company's website.
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var array|null
     */
    public ?array $attributes = null;

}
