<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Factory\Auth;

class FriendConnectProviderAuthFactory implements \l3l0\Bundle\OpenSocialBundle\Factory\Auth\FactoryInterface
{
    /**
     * @param array $options
     * @throws \InvalidArgumentException
     * @return \osapiFCAuth
     */
    public function create($options = array())
    {
        if (!isset($options['fcauth'])) {
           throw new \InvalidArgumentException('Option "fcauth" is required when you use friend connect auth');
        }

        return new \osapiFCAuth($options['fcauth']);
    }
}
