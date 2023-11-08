<?php

declare(strict_types=1);

namespace Htmxfony\Template;

class TemplateBlock
{

    public function __construct(
        private readonly string $templateFileName,
        private readonly string $blockName,
        private readonly array $context = [],
    ) {
    }

    public function getTemplateFileName(): string
    {
        return $this->templateFileName;
    }

    public function getBlockName(): string
    {
        return $this->blockName;
    }

    public function getContext(): array
    {
        return $this->context;
    }

}
