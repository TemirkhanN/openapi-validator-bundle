<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator\Policy;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TemirkhanN\OpenapiValidatorBundle\Validator\ValidatorInterface;

class LimitedValidationDecorator implements ValidatorInterface
{
    private ValidatorInterface $validator;

    /** @var PolicyInterface[] */
    private array $exclusionPolicies = [];

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function exclude(PolicyInterface $policy): void
    {
        $this->exclusionPolicies[] = $policy;
    }

    public function validate(RequestInterface $request, ResponseInterface $response): void
    {
        foreach ($this->exclusionPolicies as $exclusionPolicy) {
            if ($exclusionPolicy->isEligible($request, $response)) {
                return;
            }
        }

        $this->validator->validate($request, $response);
    }
}
