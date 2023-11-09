<?php

declare(strict_types=1);

namespace Htmxfony\Tests;

use Htmxfony\Controller\HtmxControllerTrait;
use Htmxfony\Request\HtmxRequest;
use Htmxfony\Response\HtmxRedirectResponse;
use Htmxfony\Response\HtmxRefreshResponse;
use Htmxfony\Response\HtmxResponse;
use Htmxfony\Response\HtmxStopPollingResponse;
use Htmxfony\Template\TemplateBlock;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class HtmxControllerTraitTest extends TestCase
{

    /** @var ContainerInterface  */
    private $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = $this->createMock(ContainerInterface::class);
        $this->container->method('get')->willReturnCallback(function ($id) {
            if ($id === 'twig') {
                $loader = new ArrayLoader([
                    'test.html.twig' => '[Text outside blocks]{% block block1 %}{{value1}}{% endblock %}{% block block2 %}{{value2}}{% endblock %}',
                ]);
                return new Environment($loader);
            }
            throw new InvalidArgumentException(sprintf('Unknown service ID: %s', $id));
        });
        $this->container->method('has')->willReturnCallback(function ($id) {
            return $id === 'twig';
        });
    }

    public function testRender(): void
    {
        $controller = new class ($this->container) extends AbstractController
        {
            use HtmxControllerTrait;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function index(HtmxRequest $request): HtmxResponse
            {
                return $this->render(
                    'test.html.twig',
                    [
                        'value1' => $request->get('value1'),
                        'value2' => $request->get('value2'),
                    ]
                );
            }

        };

        $htmxRequest = new HtmxRequest();
        $htmxRequest->request->set('value1', 'test1');
        $htmxRequest->request->set('value2', 'test2');
        $response = $controller->index($htmxRequest);

        $this->assertInstanceOf(HtmxResponse::class, $response);
    }

    public function testRenderBlock(): void
    {
        $controller = new class ($this->container) extends AbstractController
        {
            use HtmxControllerTrait;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function index(HtmxRequest $request): HtmxResponse
            {
                return $this->renderBlock(
                    new TemplateBlock(
                        'test.html.twig',
                        'block1',
                        ['value1' => $request->get('value1')]
                    ),
                    new TemplateBlock(
                        'test.html.twig',
                        'block2',
                        ['value2' => $request->get('value2')]
                    )
                );
            }

        };

        $htmxRequest = new HtmxRequest();
        $htmxRequest->request->set('value1', 'test1');
        $htmxRequest->request->set('value2', 'test2');
        $response = $controller->index($htmxRequest);

        $this->assertEquals('test1test2', $response->getContent());
        $this->assertInstanceOf(HtmxResponse::class, $response);
    }

    public function testRedirect(): void
    {
        $controller = new class ($this->container) extends AbstractController
        {
            use HtmxControllerTrait;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function index(HtmxRequest $request): HtmxRedirectResponse
            {
                return $this->htmxRedirect($request->get('url'));
            }

        };

        $htmxRequest = new HtmxRequest();
        $htmxRequest->request->set('url', 'https://htmx.org');
        $response = $controller->index($htmxRequest);

        $this->assertInstanceOf(HtmxRedirectResponse::class, $response);
        $this->assertEquals('https://htmx.org', $response->headers->get(HtmxRedirectResponse::HX_REDIRECT));
    }

    public function testRefresh(): void
    {
        $controller = new class ($this->container) extends AbstractController
        {
            use HtmxControllerTrait;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function index(): HtmxRefreshResponse
            {
                return $this->htmxRefresh();
            }

        };

        $response = $controller->index();

        $this->assertInstanceOf(HtmxRefreshResponse::class, $response);
        $this->assertEquals('true', $response->headers->get(HtmxRefreshResponse::HX_REFRESH));
    }

    public function testStopPolling(): void
    {
        $controller = new class ($this->container) extends AbstractController
        {
            use HtmxControllerTrait;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function index(): HtmxStopPollingResponse
            {
                return $this->htmxStopPolling();
            }

        };

        $response = $controller->index();

        $this->assertInstanceOf(HtmxStopPollingResponse::class, $response);
        $this->assertSame(HtmxStopPollingResponse::HX_CODE_STOP_POLLING, $response->getStatusCode());
    }

}
