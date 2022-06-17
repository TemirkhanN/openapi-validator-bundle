<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator\Policy;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RoutePattern implements PolicyInterface
{
    private string $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function isEligible(RequestInterface $request, ResponseInterface $response): bool
    {
        return preg_match($this->pattern, $request->getUri()->getPath()) === 1;
    }
}
