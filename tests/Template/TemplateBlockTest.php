<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Template;

use PHPUnit\Framework\TestCase;
use Htmxfony\Template\TemplateBlock;

class TemplateBlockTest extends TestCase
{

    public function testTemplateBlock(): void
    {
        $templateBlock = new TemplateBlock(
            'templateFileName',
            'blockName',
            ['prop' => 'val']
        );
        $this->assertSame('templateFileName', $templateBlock->getTemplateFileName());
        $this->assertSame('blockName', $templateBlock->getBlockName());
        $this->assertSame(['prop' => 'val'], $templateBlock->getContext());
    }

}
