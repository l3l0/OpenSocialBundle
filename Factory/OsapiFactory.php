<?php

/*
 * This file is part of the OpenSocialBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace l3l0\Bundle\OpenSocialBundle\Factory;

use l3l0\Bundle\OpenSocialBundle\Factory\Provider\FactoryInterface as ProviderFactoryInterface;
use l3l0\Bundle\OpenSocialBundle\Factory\Auth\FactoryInterface as AuthFactoryInterface;
use l3l0\Bundle\OpenSocialBundle\Factory\Storage\FactoryInterface as StorageFactoryInterface;

class OsapiFactory implements FactoryInterface
{
    /**
     * @var string
     */
    private $providerType;

    /**
     * @var string
     */
    private $storageType;

    public function __construct($providerType, $storageType)
    {
        $this->providerType = $providerType;
        $this->storageType  = $storageType;
    }

    /**
     * @var array $options
     * @return \osapi
     */
    public function create($options = array())
    {
        $options['storage']  = $this->createStorage($options);
        $options['provider'] = $this->createProvider($options);
        $options['auth']     = $this->createAuth($options);

        return new \osapi($options['provider'], $options['auth']);
    }

    /**
     * @param array $options
     * @throws \InvalidArgumentException
     * @return l3l0\Bundle\OpenSocialBundle\Factory\Provider\FactoryInterface
     */
    protected function createProvider($options = array())
    {
        $class = 'l3l0\\Bundle\\OpenSocialBundle\\Factory\\Provider\\' . $this->providerType . 'Factory';
        if (class_exists($class)) {
            $providerFactory = new $class();

            return $providerFactory->create($options);
        }

        throw new \InvalidArgumentException(sprintf('Cannot create provider for %s type', $this->providerType));
    }

    /**
     * @param array $options
     * @throws \InvalidArgumentException
     * @return l3l0\Bundle\OpenSocialBundle\Factory\Provider\FactoryInterface
     */
    protected function createAuth($options = array())
    {
        $class = 'l3l0\\Bundle\\OpenSocialBundle\\Factory\\Auth\\' . $this->providerType . 'AuthFactory';
        if (class_exists($class)) {
            $authFactory = new $class();

            return $authFactory->create($options);
        }
    }

    /**
     * @param array $options
     * @throws \InvalidArgumentException
     * @return l3l0\Bundle\OpenSocialBundle\Factory\Storage\FactoryInterface
     */
    protected function createStorage($options = array())
    {
        $class = 'l3l0\\Bundle\\OpenSocialBundle\\Factory\\Storage\\' . $this->storageType . 'Factory';
        if (class_exists($class)) {
            $storageFactory = new $class();

            return $storageFactory->create($options);
        }

        throw new \InvalidArgumentException(sprintf('Cannot create storage for %s type', $this->storageType));
    }
}
