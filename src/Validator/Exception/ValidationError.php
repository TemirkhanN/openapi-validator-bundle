<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Validator\Exception;

use Exception;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use Throwable;

class ValidationError extends Exception
{
    /**
     * @var string[]
     */
    private array $details = [];

    public static function create(Throwable $error): self
    {
        $validationError = new self(
            sprintf('Openapi specification validation failed: %s', $error->getMessage()),
            0,
            $error
        );

        do {
            $validationError->details[] = $error->getMessage();
            $error                      = $error->getPrevious();
        } while ($error !== null && self::isValidationError($error));

        return $validationError;
    }

    /**
     * @return string[]
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    private static function isValidationError(Throwable $error): bool
    {
        static $validationNamespaces = [
            'League\OpenAPIValidation\Schema\Exception',
            'League\OpenAPIValidation\PSR7\Exception',
            'League\OpenAPIValidation\PSR15\Exception',
        ];

        $errorNamespace = get_class($error);
        foreach ($validationNamespaces as $validationNamespace) {
            if (strpos($errorNamespace, $validationNamespace) === 0) {
                return true;
            }
        }

        return false;
    }
}
