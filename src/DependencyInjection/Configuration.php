<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('openapi_validator');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('specification')->end()
            ->end();

        return $treeBuilder;
    }
}
