<?php

declare(strict_types=1);

namespace Test\TemirkhanN\OpenapiValidatorBundle\Event;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use TemirkhanN\OpenapiValidatorBundle\Validator\Exception\ValidationError;
use Test\TemirkhanN\OpenapiValidatorBundle\Kernel\Kernel;

class ValidateRequestSubscriberTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    public function testNonDocumentedEndpoint(): void
    {
        self::expectException(ValidationError::class);
        self::expectExceptionMessage(
            'Openapi specification validation failed: OpenAPI spec contains no such operation [/]'
        );

        $request = Request::create('/', 'GET');

        $this->dispatchRequest($request);
    }

    public function testResponseDoesNotMatchDocumentation(): void
    {
        self::expectException(ValidationError::class);
        self::expectExceptionMessage(
            'Openapi specification validation failed: The given request matched these operations: [/pet/findByStatus,get],[/pet/{petId},get]. However, it matched not a single schema of theirs.'
        );

        $request = Request::create('/pet/findByStatus', 'GET');

        $this->dispatchRequest($request);
    }

    public function testExcludeResponseCode(): void
    {
        $request = Request::create('/error500', 'GET');

        $response = $this->dispatchRequest($request);

        self::assertEquals(500, $response->getStatusCode());
    }

    public function testExcludeRoute(): void
    {
        $request = Request::create('/some-internal/index', 'GET');

        $response = $this->dispatchRequest($request);

        self::assertEquals(200, $response->getStatusCode());
    }

    private function dispatchRequest(Request $request): Response
    {
        /** @var Kernel $kernel */
        $kernel = self::$kernel;

        return $kernel->handle($request, HttpKernelInterface::MAIN_REQUEST, false);
    }
}
