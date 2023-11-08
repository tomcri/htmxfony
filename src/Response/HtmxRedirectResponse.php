<?php

/**
 * Docs: https://htmx.org/docs/#response-headers
 */

declare(strict_types=1);

namespace Htmxfony\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HtmxRedirectResponse extends SymfonyResponse
{
    public const HX_REDIRECT = 'HX-Redirect';

    public function __construct(string $url)
    {
        parent::__construct('', self::HTTP_OK, [self::HX_REDIRECT => $url]);
    }

}
