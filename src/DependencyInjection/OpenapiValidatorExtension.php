<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use TemirkhanN\OpenapiValidatorBundle\Validator\Policy\RoutePattern;
use TemirkhanN\OpenapiValidatorBundle\Validator\Policy\StatusCode;

class OpenapiValidatorExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setParameter('openapi_validator.specification', $mergedConfig['specification']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');

        $exclusionPolicies = [];
        foreach ($mergedConfig['policy']['exclude']['paths'] as $pathRegex) {
            $exclusionPolicies[] = new Definition(RoutePattern::class, [$pathRegex]);
        }

        $ignoreStatusCodes = $mergedConfig['policy']['exclude']['status_codes'];
        if ($ignoreStatusCodes !== []) {
            $exclusionPolicies[] = new Definition(StatusCode::class, [$ignoreStatusCodes]);
        }

        if ($exclusionPolicies !== []) {
            $validatorDefinition = $container->getDefinition('openapi_validator.limited_validator');
            foreach ($exclusionPolicies as $policyDefinition) {
                $validatorDefinition->addMethodCall('exclude', [$policyDefinition]);
            }
        }
    }
}
