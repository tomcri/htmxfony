<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Response;

use Htmxfony\Response\HtmxRedirectResponse;
use PHPUnit\Framework\TestCase;

class HtmxRedirectResponseTest extends TestCase
{

    public function testGetUrl(): void
    {
        $response = new HtmxRedirectResponse('https://htmx.org');
        $this->assertSame('https://htmx.org', $response->headers->get(HtmxRedirectResponse::HX_REDIRECT));
    }

}
