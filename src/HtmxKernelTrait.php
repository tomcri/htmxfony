<?php

declare(strict_types=1);

namespace Htmxfony;

use Htmxfony\Request\HtmxRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait HtmxKernelTrait
{

    public function handle(Request $request, $type = 1, $catch = true): Response
    {
        return parent::handle(HtmxRequest::createFromGlobals(), $type, $catch);
    }

}
