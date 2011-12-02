<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use l3l0\Bundle\OpenSocialBundle\Security\Authentication\Token\FriendConnectToken;
use l3l0\Bundle\OpenSocialBundle\Factory\FactoryInterface;

class FriendConnectProvider implements AuthenticationProviderInterface
{
    private $factory = null;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }

        try {
            $osapi = $this->factory->create(array(
                'fcauth' => $token->getFcAuthToken()
            ));
        } catch (\Exception $exception) {
            throw new AuthenticationException('Cannot authenticate wihthout osapi instance');
        }

        try {
            $userId = $this->getFriendConnectUserId($osapi);
        } catch (\Exception $exception) {
            throw new AuthenticationException('Cannot retrieve friend connect user id');
        }

        $token->setUser($userId);

        return $token;
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof FriendConnectToken;
    }

    private function getFriendConnectUserId($osapi)
    {
        $batch = $osapi->newBatch();
        $batch->add($osapi->people->get(array('userId' => '@me')));
        $result = $batch->execute();

        if (is_array($result)) {
          $result = reset($result);
          if ($result && $result->getId()) {
              return (string) $result->getId();
          }
        }

        throw new \Exception();
    }
}
