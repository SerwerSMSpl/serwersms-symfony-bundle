<?php

namespace SerwerSMS\SerwerSMSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('serwer_sms');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('serwersms_username')->defaultNull()->end()
                ->scalarNode('serwersms_password')->defaultNull()->end()
                ->scalarNode('serwersms_token')->defaultNull()->end()
                ->scalarNode('serwersms_api_url')->defaultValue('https://api2.serwersms.pl')->end()
                ->integerNode('serwersms_timeout')->defaultValue(30)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
