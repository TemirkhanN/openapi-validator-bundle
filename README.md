# openapi-validator-bundle
An OpenAPI specification validator for a symfony application

It checks if the request and response from your symfony application matches your openapi documentation file.  
If the endpoint is not documented, receives or responds with mismatching payload it will throw `ValidationError`.  
This comes in handy when application has integration/functional/manual tests because it will alert early that documentation 
is outdated.  

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

