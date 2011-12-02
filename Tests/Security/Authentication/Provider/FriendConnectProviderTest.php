<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\Security\Authentication\Provider;

use l3l0\Bundle\OpenSocialBundle\Security\Authentication\Provider\FriendConnectProvider;
use l3l0\Bundle\OpenSocialBundle\Security\Authentication\Token\FriendConnectToken;

class FriendConnectProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testThatOsapiObjectIsCreatedWhenAuthenticated()
    {
        $osapiFactory = $this->getOsapiFactory('testToken');

        $provider = new FriendConnectProvider($osapiFactory);
        $token = $provider->authenticate(new FriendConnectToken('testToken'));

        $this->assertEquals('123', $token->getUser());
    }

    public function testThatCannotAuthenticateWithoutFriendConnectToken()
    {
        $osapiFactory = $this->getMockBuilder('l3l0\\Bundle\\OpenSocialBundle\\Factory\\OsapiFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $provider = new FriendConnectProvider($osapiFactory);
        $token = $provider->authenticate($this->getMock('Symfony\\Component\\Security\\Core\\Authentication\\Token\\TokenInterface'));

        $this->assertNull($token);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function testThatDoNotAuthenticateWhenCannotRetriveUserInfo()
    {
        $osapiFactory = $this->getOsapiFactory('testToken', false);

        $provider = new FriendConnectProvider($osapiFactory);
        $token = $provider->authenticate(new FriendConnectToken('testToken'));

        $this->assertEquals('userId', $token->getUser());
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function testThatDoNotAuthenticateWhenCannotCreateOsapi()
    {
        $osapiFactory = $this->getMockBuilder('l3l0\\Bundle\\OpenSocialBundle\\Factory\\OsapiFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $osapiFactory->expects($this->once())
            ->method('create')
            ->with($this->equalTo(array(
                'fcauth' => ''
            )))
            ->will($this->throwException(new \Exception()));

        $provider = new FriendConnectProvider($osapiFactory);
        $provider->authenticate(new FriendConnectToken(''));
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function testThatDoNotAuthenticateGetSomeExceptionFromOsapi()
    {
        $osapi = $this->getMockBuilder('\\osapi')
            ->disableOriginalConstructor()
            ->getMock();
        $osapi->expects($this->once())
            ->method('newBatch')
            ->will($this->throwException(new \Exception()));

        $osapiFactory = $this->getMockBuilder('l3l0\\Bundle\\OpenSocialBundle\\Factory\\OsapiFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $osapiFactory->expects($this->once())
            ->method('create')
            ->with($this->equalTo(array(
                'fcauth' => 'test123'
            )))
            ->will($this->returnValue($osapi));

        $provider = new FriendConnectProvider($osapiFactory);
        $provider->authenticate(new FriendConnectToken('test123'));
    }

    public function testThatSupportFriendConnectToken()
    {
        $osapiFactory = $this->getMockBuilder('l3l0\\Bundle\\OpenSocialBundle\\Factory\\OsapiFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $provider = new FriendConnectProvider($osapiFactory);
        $this->assertTrue($provider->supports(new FriendConnectToken('testToken')));
    }

    private function getOsapiFactory($fcAuthToken, $success = true)
    {
        $osapiFactory = $this->getMockBuilder('l3l0\\Bundle\\OpenSocialBundle\\Factory\\OsapiFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $osapiFactory->expects($this->once())
            ->method('create')
            ->with($this->equalTo(array(
                'fcauth' => $fcAuthToken
            )))
            ->will($this->returnValue($this->getOsapi($success)));

        return $osapiFactory;
    }

    private function getOsapi($notEmptyValue = true)
    {
        $osapiRequest = $this->getMockBuilder('\\osapiRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $osapiPepole = $this->getMock('\\osapiPepole', array('get'));
        $osapiPepole->expects($this->any())
            ->method('get')
            ->will($this->returnValue($osapiRequest));

        $osapiPerson = $this->getMockBuilder('\\osapiPerson')
            ->disableOriginalConstructor()
            ->getMock();
        $osapiPerson->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(123));

        $batch = $this->getMockBuilder('\\osapiBatch')
            ->disableOriginalConstructor()
            ->getMock();
        $batch->expects($this->any())
            ->method('add');
        $executeMethod = $batch->expects($this->any())
            ->method('execute');

        if ($notEmptyValue) {
            $executeMethod->will($this->returnValue(array(0 => $osapiPerson)));
        } else {
            $executeMethod->will($this->returnValue(array()));
        }

        $osapi = $this->getMockBuilder('\\osapi')
            ->disableOriginalConstructor()
            ->getMock();
        $osapi->expects($this->any())
            ->method('__get')
            ->will($this->returnValue($osapiPepole));
        $osapi->expects($this->once())
            ->method('newBatch')
            ->will($this->returnValue($batch));

        return $osapi;
    }
}
