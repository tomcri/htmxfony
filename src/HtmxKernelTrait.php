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
        if (!$request instanceof HtmxRequest) {
            $request = new HtmxRequest(
                $request->query->all(),
                $request->request->all(),
                $request->attributes->all(),
                $request->cookies->all(),
                $request->files->all(),
                $request->server->all(),
                $request->getContent()
            );
        }

        return parent::handle($request, $type, $catch);
    }

}
