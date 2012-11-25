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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * DI extension
 * 
 * @author suncat2000 <nikolay.kotovsky@gmail.com>
 */
class WeatherUndergroundExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('weather_underground.apikey', $config['apikey']);
        $container->setParameter('weather_underground.format', $config['format']);
        $container->setParameter('weather_underground.host_data_features', $config['host_data_features']);
        $container->setParameter('weather_underground.host_autocomlete', $config['host_autocomlete']);
    }
}
