<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Required action processing 3D Secure payments.
 */
class CheckoutAcceptedNextStep
{
    /**
     * Where the end user is redirected.
     *
     * @var string|null
     */
    public ?string $url = null;

    /**
     * Method used to complete the redirect.
     *
     * @var string|null
     */
    public ?string $method = null;

    /**
     * Refers to a url where the end user is redirected once the payment processing completes.
     *
     * @var string|null
     */
    public ?string $redirectUrl = null;

    /**
     * Indicates allowed mechanisms for redirecting an end user. If both values are provided to ensure a redirect takes place in either.
     *
     * @var string[]|null
     */
    public ?array $mechanism = null;

    /**
     * Contains parameters essential for form redirection. Number of object keys and their content can vary.
     *
     * @var CheckoutAcceptedNextStepPayload|null
     */
    public ?CheckoutAcceptedNextStepPayload $payload = null;

}
