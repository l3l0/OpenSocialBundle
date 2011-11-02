<?php

namespace l3l0\Bundle\OpenSocialBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('l3l0_open_social');

        $rootNode
            ->children()
                ->scalarNode('site_id')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('types')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('provider')->defaultValue('FriendConnectProvider')->end()
                        ->scalarNode('storage')->defaultValue('FileStorage')->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
