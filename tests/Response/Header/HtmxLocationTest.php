<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Response\Header;

use Htmxfony\Response\Header\HtmxLocation;
use PHPUnit\Framework\TestCase;

class HtmxLocationTest extends TestCase
{

    public function testGetPath(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertSame('https://htmx.org', $location->getPath());
    }

    public function testGetSource(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getSource());

        $location = new HtmxLocation('https://htmx.org', 'https://htmx.org');
        $this->assertSame('https://htmx.org', $location->getSource());
    }

    public function testGetEvent(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getEvent());

        $location = new HtmxLocation('https://htmx.org', null, 'click');
        $this->assertSame('click', $location->getEvent());
    }

    public function testGetHandler(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getHandler());

        $location = new HtmxLocation('https://htmx.org', null, null, 'click');
        $this->assertSame('click', $location->getHandler());
    }

    public function testGetTarget(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getTarget());

        $location = new HtmxLocation('https://htmx.org', null, null, null, 'click');
        $this->assertSame('click', $location->getTarget());
    }

    public function testGetSwap(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getSwap());

        $location = new HtmxLocation('https://htmx.org', null, null, null, null, 'click');
        $this->assertSame('click', $location->getSwap());
    }

    public function testGetValues(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getValues());

        $location = new HtmxLocation('https://htmx.org', null, null, null, null, null, ['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], $location->getValues());
    }

    public function testGetHeaders(): void
    {
        $location = new HtmxLocation('https://htmx.org');
        $this->assertNull($location->getHeaders());

        $location = new HtmxLocation('https://htmx.org', null, null, null, null, null, null, ['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], $location->getHeaders());
    }

}
