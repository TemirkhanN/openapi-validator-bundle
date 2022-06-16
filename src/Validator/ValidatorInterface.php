<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TemirkhanN\OpenapiValidatorBundle\Validator\Exception\ValidationError;

interface ValidatorInterface
{
    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws ValidationError
     */
    public function validate(RequestInterface $request, ResponseInterface $response): void;
}
