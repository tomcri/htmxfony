<?php

declare(strict_types=1);

namespace Htmxfony\Tests;

use Htmxfony\HtmxKernelTrait;
use Htmxfony\Request\HtmxRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

class HtmxKernelTraitTest extends TestCase
{

    public function testHtmxKernelTrait(): void
    {
        $container = new Container();
        $container->set('http_kernel', (function () {
            $controllerResolver = $this->createMock(ControllerResolverInterface::class);
            $controllerResolver->method('getController')->willReturn(function (Request $request) {
                $this->assertInstanceOf(HtmxRequest::class, $request);

                return new Response('', Response::HTTP_OK);
            });

            $assertRequest = function ($request) {
                $this->assertInstanceOf(HtmxRequest::class, $request);
            };
            $eventDispatcher = new EventDispatcher();
            $eventDispatcher->addSubscriber(new class($assertRequest) implements EventSubscriberInterface {

                /** @var callable */
                private $assertRequest;

                public function __construct(callable $assertRequest)
                {
                    $this->assertRequest = $assertRequest;
                }

                public static function getSubscribedEvents()
                {
                    return [
                        KernelEvents::REQUEST => [
                            ['testRequest', 90],
                        ],
                    ];
                }

                public function testRequest(RequestEvent $event): void
                {
                    ($this->assertRequest)($event->getRequest());
                }

            });

            return new HttpKernel(
                $eventDispatcher,
                $controllerResolver,
                new RequestStack(),
                new ArgumentResolver()
            );
        })());

        $kernel = new class ('test', true) extends Kernel {
            use HtmxKernelTrait;

            public function setContainer(ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function registerBundles(): iterable
            {
                return [];
            }

            public function registerContainerConfiguration(LoaderInterface $loader)
            {
            }

        };
        $kernel->boot();
        $kernel->setContainer($container);

        $response = $kernel->handle(new Request());

        $this->assertSame('', $response->getContent());
    }

}
