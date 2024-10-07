<?php

declare(strict_types=1);

namespace Htmxfony\Template;

class TemplateBlock
{

    private $blockName;

    private $template;

    public function __construct(
        string $templateFileName,
        string $blockName,
        array $context = []
    ) {
        $this->blockName = $blockName;
        $this->template = new Template($templateFileName, $context);
    }

    public function getTemplateFileName(): string
    {
        return $this->template->getTemplateFileName();
    }

    public function getBlockName(): string
    {
        return $this->blockName;
    }

    public function getContext(): array
    {
        return $this->template->getContext();
    }

}
