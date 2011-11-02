<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Factory\Auth;

class OAuth2AuthFactory implements \l3l0\Bundle\OpenSocialBundle\Factory\Auth\FactoryInterface
{
    private $requiredOptions = array('consumer_key', 'consumer_secret');

    /**
     * @param array $options
     * @throws \InvalidArgumentException
     * @return \osapiOAuth2Legged
     */
    public function create($options = array())
    {
        foreach ($this->requiredOptions as $optionKey) {
            if (!isset($options[$optionKey])) {
               throw new \InvalidArgumentException(sprintf('Option "%s" is required when you use oauth2 auth', $optionKey));
            }
        }

        return new \osapiOAuth2Legged($options['consumer_key'], $options['consumer_secret'], isset($options['user_id']) ?  $options['user_id'] : null);
    }
}
