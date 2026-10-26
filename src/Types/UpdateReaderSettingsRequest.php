<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Menu lock settings to update for a Solo reader.
 */
class UpdateReaderSettingsRequest
{
    /**
     * Menu lock configuration. Provide at least one of `enabled` or `passcode`.
     *
     * @var UpdateReaderSettingsRequestMenuLock
     */
    public UpdateReaderSettingsRequestMenuLock $menuLock;

    /**
     * Create request DTO.
     *
     * @param UpdateReaderSettingsRequestMenuLock $menuLock
     */
    public function __construct(
        UpdateReaderSettingsRequestMenuLock $menuLock
    ) {
        \SumUp\Hydrator::hydrate([
            'menu_lock' => $menuLock,
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
            'menu_lock' => 'menuLock',
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
