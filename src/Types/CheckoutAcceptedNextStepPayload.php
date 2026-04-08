<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Contains parameters essential for form redirection. Number of object keys and their content can vary.
 */
class CheckoutAcceptedNextStepPayload
{
    /**
     *
     * @var mixed|null
     */
    public mixed $paReq = null;

    /**
     *
     * @var mixed|null
     */
    public mixed $md = null;

    /**
     *
     * @var mixed|null
     */
    public mixed $termUrl = null;

}
