<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Template;

use Htmxfony\Template\Template;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{

    public function testTemplateBlock(): void
    {
        $templateBlock = new Template(
            'templateFileName',
            ['prop' => 'val'],
        );
        $this->assertSame('templateFileName', $templateBlock->getTemplateFileName());
        $this->assertSame(['prop' => 'val'], $templateBlock->getContext());
    }

}
