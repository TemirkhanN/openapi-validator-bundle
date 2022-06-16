<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator;

use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use League\OpenAPIValidation\PSR7\RequestValidator;
use League\OpenAPIValidation\PSR7\ResponseValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use League\OpenAPIValidation\Schema\Exception\InvalidSchema;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SplFileInfo;
use TemirkhanN\OpenapiValidatorBundle\Validator\Exception\ValidationError;
use UnexpectedValueException;

final class Validator implements ValidatorInterface
{
    private RequestValidator $requestValidator;
    private ResponseValidator $responseValidator;

    public function __construct(string $specificationPath)
    {
        $factory = $this->createFactory($specificationPath);

        $this->requestValidator  = $factory->getRequestValidator();
        $this->responseValidator = $factory->getResponseValidator();
    }

    public function validate(RequestInterface $request, ResponseInterface $response): void
    {
        try {
            $endpointSchema = $this->requestValidator->validate($request);
            $this->responseValidator->validate($endpointSchema, $response);
        } catch (ValidationFailed | InvalidSchema $e) {
            throw ValidationError::create($e);
        }
    }

    private function createFactory(string $specificationFilePath): ValidatorBuilder
    {
        $specification = new SplFileInfo($specificationFilePath);

        if (!$specification->isFile() || !$specification->isReadable()) {
            throw new UnexpectedValueException(
                sprintf('File "%s" does not exist or is not readable', $specification->getPath())
            );
        }

        if (!$specification->openFile()->getSize()) {
            throw new UnexpectedValueException('Specification can not be empty');
        }

        $format = strtolower($specification->getExtension());

        $factory = new ValidatorBuilder();

        switch ($format) {
            case 'yml':
            case 'yaml':
                $factory->fromYamlFile($specification->getRealPath());
                break;
            case 'json':
                $factory->fromJsonFile($specification->getRealPath());
                break;
            default:
                throw new UnexpectedValueException(
                    sprintf('Specification format "%s" is not supported(yml,yaml,json)', $format)
                );
        }

        return $factory;
    }
}
