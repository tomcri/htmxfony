<?php

declare(strict_types=1);

namespace Htmxfony;

use Htmxfony\Request\HtmxRequest;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

trait HtmxKernelTrait
{

    public function handle(SymfonyRequest $request, int $type = HttpKernelInterface::MAIN_REQUEST, bool $catch = true): Response
    {
        return parent::handle(HtmxRequest::createFromGlobals(), $type, $catch);
    }

}
