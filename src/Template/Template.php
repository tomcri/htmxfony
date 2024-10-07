<?php

declare(strict_types=1);

namespace Htmxfony\Template;

class Template
{

    private $view;

    private $context;

    public function __construct(
        string $view,
        array $context,
    ) {
        $this->view = $view;
        $this->context = $context;
    }

    public function getTemplateFileName(): string
    {
        return $this->view;
    }

    public function getContext(): array
    {
        return $this->context;
    }

}
