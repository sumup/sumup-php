<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Saved customer details.
 */
class Customer
{
    /**
     * Unique ID of the customer.
     *
     * @var string
     */
    public string $customerId;

    /**
     * Personal details for the customer.
     *
     * @var PersonalDetails|null
     */
    public ?PersonalDetails $personalDetails = null;

    /**
     * Create request DTO.
     *
     * @param string $customerId
     * @param PersonalDetails|null $personalDetails
     */
    public function __construct(
        string $customerId,
        ?PersonalDetails $personalDetails = null
    ) {
        \SumUp\Hydrator::hydrate([
            'customer_id' => $customerId,
            'personal_details' => $personalDetails,
        ], self::class, $this);
    }

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        self::assertRequiredFields($data, [
            'customer_id' => 'customerId',
        ]);

        $request = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        \SumUp\Hydrator::hydrate($data, self::class, $request);

        return $request;
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $requiredFields
     */
    private static function assertRequiredFields(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $serializedName => $propertyName) {
            if (!array_key_exists($serializedName, $data) && !array_key_exists($propertyName, $data)) {
                throw new \InvalidArgumentException(sprintf('Missing required field "%s".', $serializedName));
            }
        }
    }

}
