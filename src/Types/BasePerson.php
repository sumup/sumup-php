<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Base schema for a person associated with a merchant. This can be a legal representative, business owner (ultimate beneficial owner), or an officer. A legal representative is the person who registered the merchant with SumUp. They should always have a `user_id`.
 *
 */
class BasePerson
{
    /**
     * The unique identifier for the person. This is a [typeid](https://github.com/sumup/typeid).
     *
     * @var string
     */
    public string $id;

    /**
     * A corresponding identity user ID for the person, if they have a user account.
     *
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * The date of birth of the individual, represented as an ISO 8601:2004 [ISO8601‑2004] YYYY-MM-DD format.
     *
     * @var string|null
     */
    public ?string $birthdate = null;

    /**
     * The first name(s) of the individual.
     *
     * @var string|null
     */
    public ?string $givenName = null;

    /**
     * The last name(s) of the individual.
     *
     * @var string|null
     */
    public ?string $familyName = null;

    /**
     * Middle name(s) of the End-User. Note that in some cultures, people can have multiple middle names; all can be present, with the names being separated by space characters. Also note that in some cultures, middle names are not used.
     *
     * @var string|null
     */
    public ?string $middleName = null;

    /**
     * A publicly available phone number in [E.164](https://en.wikipedia.org/wiki/E.164) format.
     *
     * @var string|null
     */
    public ?string $phoneNumber = null;

    /**
     * A list of roles the person has in the merchant or towards SumUp. A merchant must have at least one person with the relationship `representative`.
     *
     * @var string[]|null
     */
    public ?array $relationships = null;

    /**
     *
     * @var Ownership|null
     */
    public ?Ownership $ownership = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $address = null;

    /**
     * A list of country-specific personal identifiers.
     *
     * @var PersonalIdentifier[]|null
     */
    public ?array $identifiers = null;

    /**
     * An [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
     * country code. This definition users `oneOf` with a two-character string
     * type to allow for support of future countries in client code.
     *
     * @var string|null
     */
    public ?string $citizenship = null;

    /**
     * The persons nationality. May be an [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) country code, but legacy data may not conform to this standard.
     *
     * @var string|null
     */
    public ?string $nationality = null;

    /**
     * An [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) country code representing the country where the person resides.
     *
     * @var string|null
     */
    public ?string $countryOfResidence = null;

    /**
     * The version of the resource. The version reflects a specific change submitted to the API via one of the `PATCH` endpoints.
     *
     * @var string|null
     */
    public ?string $version = null;

    /**
     * Reflects the status of changes submitted through the `PATCH` endpoints for the merchant or persons. If some changes have not been applied yet, the status will be `pending`. If all changes have been applied, the status `done`.
     * The status is only returned after write operations or on read endpoints when the `version` query parameter is provided.
     *
     * @var string|null
     */
    public ?string $changeStatus = null;

}
