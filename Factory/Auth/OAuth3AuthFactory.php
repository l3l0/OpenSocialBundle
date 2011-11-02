<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Factory\Auth;

class OAuth3AuthFactory implements \l3l0\Bundle\OpenSocialBundle\Factory\Auth\FactoryInterface
{
    private $requiredOptions = array('consumer_key', 'consumer_secret', 'provider', 'storage');

    /**
     * @param array $options
     * @throws \InvalidArgumentException
     * @return \osapiOAuth3Legged
     */
    public function create($options = array())
    {
        foreach ($this->requiredOptions as $optionKey) {
            if (!isset($options[$optionKey])) {
               throw new \InvalidArgumentException(sprintf('Option "%s" is required when you use oauth3 auth', $optionKey));
            }
        }

        return new \osapiOAuth3Legged($options['consumer_key'], $options['consumer_secret'], $options['storage'], $options['provider']);
    }
}
