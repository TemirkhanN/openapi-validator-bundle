<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator\Policy;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface PolicyInterface
{
    public function isEligible(RequestInterface $request, ResponseInterface $response): bool;
}
