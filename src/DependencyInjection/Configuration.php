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
                ->arrayNode('policy')->addDefaultsIfNotSet()
                     ->children()
                        ->arrayNode('exclude')->addDefaultsIfNotSet()
                        ->info('Exclude requests matching following policy from validation')
                            ->children()
                                ->arrayNode('paths')
                                    ->scalarPrototype()->end()
                                ->end()
                                ->arrayNode('status_codes')
                                    ->defaultValue([500])
                                    ->integerPrototype()->end()
                                ->end()
                            ->end()
                        ->end()
                     ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
