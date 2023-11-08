<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Response\Header;

use Htmxfony\Response\Header\HtmxTrigger;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

class HtmxTriggerTest extends TestCase
{

    public function testGetName(): void
    {
        $trigger = new HtmxTrigger('foo');
        $this->assertSame('foo', $trigger->getName());
    }

    public function testGetDataNull(): void
    {
        $trigger = new HtmxTrigger('foo');
        $this->assertNull($trigger->getData());

        $trigger = new HtmxTrigger('foo', null);
        $this->assertNull($trigger->getData());
    }

    public function testGetDataString(): void
    {
        $trigger = new HtmxTrigger('foo', 'bar');
        $this->assertSame('bar', $trigger->getData());
    }

    public function testGetDataArray(): void
    {
        $trigger = new HtmxTrigger('foo', ['bar']);
        $this->assertSame(['bar'], $trigger->getData());
    }

    public function testGetDataJsonSerializable(): void
    {
        $trigger = new HtmxTrigger('foo', new class implements JsonSerializable {

            public function jsonSerialize(): array
            {
                return ['foo' => 'bar'];
            }

        });

        $this->assertSame(json_encode(['foo' => 'bar']), json_encode($trigger->getData()));
    }

}
