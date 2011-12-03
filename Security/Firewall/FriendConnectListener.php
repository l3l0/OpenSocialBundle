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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use l3l0\Bundle\OpenSocialBundle\Security\Authentication\Token\FriendConnectToken;

class FriendConnectListener implements ListenerInterface
{
    /**
     * @var Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface
     */
    private $securityContext;

    /**
     * @var string
     */
    private $siteId;

    /**
     * @var string
     */
    private $publicPath = null;

    /**
     * @param SecurityContextInterface        $securityContext
     * @param AuthenticationManagerInterface  $authenticationManager
     * @param string                          $siteId
     */
    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, $siteId, $publicPath = null)
    {
        if (!$siteId) {
            throw new \InvalidArgumentException('$siteId must not be empty.');
        }

        $this->siteId                = $siteId;
        $this->securityContext       = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->publicPath            = $publicPath;
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

        if ($this->publicPath) {
            $response = new RedirectResponse($this->publicPath);
        } else {
            $response = new Response();
        }
        $response->setStatusCode(403);

        $event->setResponse($response);
    }

    /**
     * @param Request $request
     * @return string
     * @codeCoverageIgnore
     */
    protected function getFcAuthKey(Request $request)
    {
        return $request->cookies->get('fcauth' . $this->siteId, '');
    }
}
