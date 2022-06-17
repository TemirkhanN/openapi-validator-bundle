<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator\Policy;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class StatusCode implements PolicyInterface
{
    /**
     * @var int[]
     */
    private array $eligibleStatusCodes = [];

    /**
     * @param int[] $eligibleStatusCodes
     */
    public function __construct(array $eligibleStatusCodes)
    {
        $this->eligibleStatusCodes = $eligibleStatusCodes;
    }

    public function isEligible(RequestInterface $request, ResponseInterface $response): bool
    {
        return in_array($response->getStatusCode(), $this->eligibleStatusCodes);
    }
}
