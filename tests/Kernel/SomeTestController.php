<?php

declare(strict_types=1);

namespace Test\TemirkhanN\OpenapiValidatorBundle\Kernel;

use Symfony\Component\HttpFoundation\Response;

class SomeTestController
{
    public function index(): Response
    {
        return new Response();
    }
}
