<?php

/*
 * This file is part of the OpenSocialBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace l3l0\Bundle\OpenSocialBundle\Tests\Security\Firewall;

use l3l0\Bundle\OpenSocialBundle\Security\Firewall\FriendConnectListener;

class FriendConnectListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testThatCanAttemptAuthenticationWithFriendConnect()
    {
        $authManager = $this->getAuthenticationManager();
        $authManager->expects($this->once())
            ->method('authenticate')
            ->with($this->isInstanceOf('l3l0\\Bundle\\OpenSocialBundle\\Security\\Authentication\\Token\\FriendConnectToken'))
            ->will($this->returnValue($this->getMock('l3l0\\Bundle\\OpenSocialBundle\\Security\\Authentication\\Token\\FriendConnectToken')));

        $securityContext = $this->getSecurityContext();
        $securityContext->expects($this->once())
            ->method('setToken')
            ->with($this->isInstanceOf('l3l0\\Bundle\\OpenSocialBundle\\Security\\Authentication\\Token\\FriendConnectToken'));

        $listener = $this->getMock('l3l0\\Bundle\\OpenSocialBundle\\Security\\Firewall\\FriendConnectListener',
            array(
                'getFcAuthKey'
            ),
            array(
                $securityContext,
                $authManager,
                'site_id'
            ));
        $listener->expects($this->once())
            ->method('getFcAuthKey')
            ->will($this->returnValue('testFcAuthToken'));

        $listener->handle($this->getResponseEvent());
    }

    public function testThatCanSetEventResponse()
    {
        $authManager = $this->getAuthenticationManager();
        $authManager->expects($this->once())
            ->method('authenticate')
            ->with($this->isInstanceOf('l3l0\\Bundle\\OpenSocialBundle\\Security\\Authentication\\Token\\FriendConnectToken'))
            ->will($this->returnValue($this->getMock('Symfony\\Component\\HttpFoundation\\Response')));

        $securityContext = $this->getSecurityContext();
        $securityContext->expects($this->never())
            ->method('setToken');

        $listener = $this->getMock('l3l0\\Bundle\\OpenSocialBundle\\Security\\Firewall\\FriendConnectListener',
            array(
                'getFcAuthKey'
            ),
            array(
                $securityContext,
                $authManager,
                'site_id'
            ));
        $listener->expects($this->once())
            ->method('getFcAuthKey')
            ->will($this->returnValue('testFcAuthToken'));

        $listener->handle($this->getResponseEvent());
    }

    public function testThatAuthenticationExceptionIsHandled()
    {
        $authManager = $this->getAuthenticationManager();
        $authManager->expects($this->once())
            ->method('authenticate')
            ->with($this->isInstanceOf('l3l0\\Bundle\\OpenSocialBundle\\Security\\Authentication\\Token\\FriendConnectToken'))
            ->will($this->throwException(new \Symfony\Component\Security\Core\Exception\AuthenticationException('testMessage')));

        $listener = $this->getMock('l3l0\\Bundle\\OpenSocialBundle\\Security\\Firewall\\FriendConnectListener',
            array(
                'getFcAuthKey'
            ),
            array(
                $this->getSecurityContext(),
                $authManager,
                'site_id'
            ));
        $listener->expects($this->once())
            ->method('getFcAuthKey')
            ->will($this->returnValue('testFcAuthToken'));

        $listener->handle($this->getResponseEvent());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithoutSiteId()
    {
        $listener = new FriendConnectListener(
            $this->getSecurityContext(),
            $this->getAuthenticationManager(),
            ''
        );
    }

    /**
     * @return Symfony\Component\Security\Core\SecurityContextInterface
     */
    private function getSecurityContext()
    {
        $securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');

        return $securityContext;
    }

    /**
     * @return Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface
     */
    private function getAuthenticationManager()
    {
        $authenticationManagerMock = $this->getMock('Symfony\\Component\\Security\\Core\\Authentication\\AuthenticationManagerInterface');

        return $authenticationManagerMock;
    }

    /**
     * @return Symfony\Component\HttpKernel\Event\GetResponseEvent
     */
    private function getResponseEvent()
    {
        $responseEventMock = $this->getMock('Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent', array('getRequest'), array(), '', false);
        $responseEventMock->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($this->getRequest()));

        return $responseEventMock;
    }

    /**
     * @return Symfony\Component\HttpFoundation\Request
     */
    private function getRequest()
    {
        $requestMock = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalClone()
            ->getMock();

        return $requestMock;
    }
}
