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

    public function testThatPublicPathOptionIsPassToListener()
    {
        $factory = new OpenSocialFactory();

        $definition = $this->getMock('Symfony\\Component\\DependencyInjection\\Definition');
        $definition->expects($this->exactly(1))
            ->method('replaceArgument')
            ->with($this->equalTo(3), $this->equalTo('/publicPath'));

        $containerBuilder = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $containerBuilder->expects($this->at(1))
            ->method('setDefinition')
            ->will($this->returnValue($definition));

        $factory->create($containerBuilder, 'someId', array('public_path' => '/publicPath'), null, 'defaultEntryPoint');
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

    public function testThatPublicPathOptionIsAddedToNode()
    {
        $factory = new OpenSocialFactory();

        $nodeDefinition = $this->getMockBuilder('Symfony\\Component\\Config\\Definition\\Builder\\ArrayNodeDefinition')
            ->disableOriginalConstructor()
            ->getMock();

        $scalarNodeDefinition = $this->getMockBuilder('Symfony\\Component\\Config\\Definition\\Builder\\ScalarNodeDefinition')
            ->disableOriginalConstructor()
            ->getMock();
        $scalarNodeDefinition->expects($this->exactly(1))
            ->method('defaultValue')
            ->with($this->equalTo('/'))
            ->will($this->returnSelf());

        $nodeBuilder = $this->getMock('Symfony\\Component\\Config\\Definition\\Builder\\NodeBuilder');
        $nodeBuilder->expects($this->exactly(1))
            ->method('scalarNode')
            ->with($this->equalTo('public_path'))
            ->will($this->returnValue($scalarNodeDefinition));

        $nodeDefinition->expects($this->once())
            ->method('children')
            ->will($this->returnValue($nodeBuilder));

        $factory->addConfiguration($nodeDefinition);
    }

    private function getContainerBuilder()
    {
        $containerMock = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $containerMock->expects($this->exactly(2))
            ->method('setDefinition');

        return $containerMock;
    }
}
