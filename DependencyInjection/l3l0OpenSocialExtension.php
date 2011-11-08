<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class l3l0OpenSocialExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('l3l0_open_social.site_id', $config['site_id']);

        $this->registerClassConfiguration($config['types'], $container, $loader);
    }

    /**
     * Loads the factory classes configuration.
     *
     * @param array $config A validation configuration array
     * @param ContainerBuilder $container A ContainerBuilder instance
     * @param XmlFileLoader $loader An XmlFileLoader instance
     */
    private function registerClassConfiguration(array $config, ContainerBuilder $container, Loader\XmlFileLoader $loader)
    {
        foreach (array('auth', 'provider', 'storage') as $attribute) {
            if (isset($config[$attribute])) {
                $container->setParameter('l3l0_open_social.' . $attribute . '.type', $config[$attribute]);
            }
        }
    }
}
