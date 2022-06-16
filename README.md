# openapi-validator-bundle
An OpenAPI specification validator for a symfony application

## Installation

Not ready yet.

```bash
composer require temirkhann/openapi-validator-bundle
```

## Usage

Enable bundle in `config/bundles.php`

```php

// Usually you don't want validation to work on your production server.  
// So, enable it for all envs and disable for prod
return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['test' => true],
    ....
    TemirkhanN\OpenapiValidatorBundle\OpenapiValidatorBundle::class => ['all' => true, 'prod' => false],
];

```


Declare configuration in `config/packages/openapi_validator.yaml` as follows:  
```yaml
openapi_validator:
  # Path to your openapi specification (json or yaml)
  # Only local file is accepted (http links won't work)
  specification: '%kernel.project_dir%/openapi.yaml'

```

