<?php

declare(strict_types=1);

namespace Htmxfony\Controller;

use Htmxfony\Response\HtmxRedirectResponse;
use Htmxfony\Response\HtmxRefreshResponse;
use Htmxfony\Response\HtmxResponse;
use Htmxfony\Response\HtmxStopPollingResponse;
use Htmxfony\Template\Template;
use Htmxfony\Template\TemplateBlock;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Twig\TemplateWrapper;

trait HtmxControllerTrait
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    protected function htmxRenderBlock(TemplateBlock ...$blocks): HtmxResponse
    {
        $content = '';
        foreach ($blocks as $block) {
            /** @var TemplateWrapper $template */
            $template = $this->container->get('twig')->load($block->getTemplateFileName());
            $content .= $template->renderBlock($block->getBlockName(), $block->getContext());
        }

        return new HtmxResponse($content);
    }

    protected function htmxRender(string $view, array $parameters = [], ?Response $response = null): HtmxResponse
    {
        if ($response === null) {
            $response = new HtmxResponse();
        }

        return parent::render($view, $parameters, $response);
    }

    protected function htmxRedirect(string $url): HtmxRedirectResponse
    {
        return new HtmxRedirectResponse($url);
    }

    protected function htmxRedirectToRoute(string $route, array $parameters = []): HtmxRedirectResponse
    {
        return new HtmxRedirectResponse($this->generateUrl($route, $parameters));
    }

    protected function htmxRefresh(): HtmxRefreshResponse
    {
        return new HtmxRefreshResponse();
    }

    protected function htmxStopPolling(): HtmxStopPollingResponse
    {
        return new HtmxStopPollingResponse();
    }

    protected function htmxRenderTemplate(Template ...$templates): HtmxResponse
    {
        $content = '';
        foreach ($templates as $template) {
            $content .= $this->container->get('twig')->render($template->getTemplateFileName(), $template->getContext());
        }

        return new HtmxResponse($content);
    }

}
