<?php

/*
 * This file is part of the OpenSocialBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace l3l0\Bundle\OpenSocialBundle\Security\Firewall;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use l3l0\Bundle\OpenSocialBundle\Security\Authentication\Token\FriendConnectToken;

class FriendConnectListener implements ListenerInterface
{
    private $authenticationManager;
    private $securityContext;
    private $siteId;

    /**
     * @param SecurityContextInterface        $securityContext
     * @param AuthenticationManagerInterface  $authenticationManager
     * @param string                          $siteId
     */
    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, $siteId)
    {
        if (!$siteId) {
            throw new \InvalidArgumentException('$siteId must not be empty.');
        }

        $this->siteId                = $siteId;
        $this->securityContext       = $securityContext;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $token   = new FriendConnectToken($this->getFcAuthKey($request));

        try {
            $returnValue = $this->authenticationManager->authenticate($token);
            if ($returnValue instanceof TokenInterface) {
                return $this->securityContext->setToken($returnValue);
            } else if ($returnValue instanceof Response) {
                return $event->setResponse($returnValue);
            }
        } catch (AuthenticationException $e) {
        }

        $response = new Response();
        $response->setStatusCode(403);
        $event->setResponse($response);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getFcAuthKey(Request $request)
    {
        return $request->cookies->get('fcauth' . $this->siteId, '');
    }
}
