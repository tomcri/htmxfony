<?php

/**
 * Docs: https://htmx.org/docs/#response-headers
 */

declare(strict_types=1);

namespace Htmxfony\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HtmxRefreshResponse extends SymfonyResponse
{
    public const HX_REFRESH = 'HX-Refresh';

    public function __construct()
    {
        parent::__construct('', self::HTTP_OK, [self::HX_REFRESH => 'true']);
    }

}
