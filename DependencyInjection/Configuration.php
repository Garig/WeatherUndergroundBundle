<?php

/*
 * This file is part of the WeatherUndergroundBundle.
 *
 * (c) Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SunCat\WeatherUndergroundBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration
 * 
 * @author suncat2000 <nikolay.kotovsky@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('weather_underground');

        $rootNode
            ->children()
                ->scalarNode('apikey')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('format')->defaultValue('json')
                    ->validate()
                        ->ifNotInArray(array('json', 'xml'))
                        ->thenInvalid('Invalid {format} for doctype param "%s"')
                    ->end()
                ->end()
                ->scalarNode('host_data_features')
                    ->defaultValue('http://api.wunderground.com')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('host_autocomlete')
                    ->defaultValue('http://autocomplete.wunderground.com')
                    ->cannotBeEmpty()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
