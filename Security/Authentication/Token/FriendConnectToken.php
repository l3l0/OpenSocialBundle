<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class FriendConnectToken extends AbstractToken
{
    private $fcAuthToken = '';

    public function __construct($fcAuthToken = '', array $roles = array())
    {
        parent::__construct($roles);

        if ($fcAuthToken) {
            $this->fcAuthToken = $fcAuthToken;
            $this->setAuthenticated(true);
        }
    }

    /**
     * @return string
     */
    public function getCredentials()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getFcAuthToken()
    {
        return $this->fcAuthToken;
    }
}
