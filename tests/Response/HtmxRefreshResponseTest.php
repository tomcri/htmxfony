<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Response;

use Htmxfony\Response\HtmxRefreshResponse;
use PHPUnit\Framework\TestCase;

class HtmxRefreshResponseTest extends TestCase
{

    public function testRefreshHeader(): void
    {
        $response = new HtmxRefreshResponse();
        $this->assertSame('true', $response->headers->get(HtmxRefreshResponse::HX_REFRESH));
    }

}
