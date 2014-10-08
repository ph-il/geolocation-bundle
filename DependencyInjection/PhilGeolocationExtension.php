<?php

namespace Phil\GeolocationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PhilGeolocationExtension extends Extension
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

        if (!isset($config['default'])) {
            throw new \InvalidArgumentException(
                'The "default" option must be set'
            );
        }
        elseif (!isset($config['default']['latitude'])) {
            throw new \InvalidArgumentException(
                'The "latitude" option must be set'
            );
        }
        elseif (!isset($config['default']['longitude'])) {
            throw new \InvalidArgumentException(
                'The "longitude" option must be set'
            );
        }
        elseif (!isset($config['default']['city'])) {
            throw new \InvalidArgumentException(
                'The "city" option must be set'
            );
        }

        $container->setParameter('phil.geolocation.default.latitude', $config['default']['latitude']);
        $container->setParameter('phil.geolocation.default.longitude', $config['default']['longitude']);
        $container->setParameter('phil.geolocation.default.city', $config['default']['city']);

    }
}
