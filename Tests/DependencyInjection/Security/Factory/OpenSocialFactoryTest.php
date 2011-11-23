<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\DependencyInjection\Factory\Security;

use l3l0\Bundle\OpenSocialBundle\DependencyInjection\Security\Factory\OpenSocialFactory;

class OpenSocialFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThatProviderIdKeyIsCreated()
    {
        $factory = new OpenSocialFactory();
        $factoryKeys = $factory->create($this->getContainerBuilder(), 'someId', array(), null, 'defaultEntryPoint');

        $this->assertEquals('security.authentication.provider.osapi.someId', $factoryKeys[0]);
    }

    public function testThatListenerIdKeyIsCreated()
    {
        $factory = new OpenSocialFactory();
        $factoryKeys = $factory->create($this->getContainerBuilder(), 'someId', array(), null, 'defaultEntryPoint');

        $this->assertEquals('security.authentication.listener.osapi.someId', $factoryKeys[1]);
    }

    public function testThatCalledAtPreAuthPosition()
    {
        $factory = new OpenSocialFactory();

        $this->assertEquals('pre_auth', $factory->getPosition());
    }

    public function testThatHaveValidConfigurationKey()
    {
        $factory = new OpenSocialFactory();

        $this->assertEquals('l3l0_osapi', $factory->getKey());
    }

    private function getContainerBuilder()
    {
        $containerMock = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $containerMock->expects($this->exactly(2))
            ->method('setDefinition');

        return $containerMock;
    }
}
