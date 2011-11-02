<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\DependencyInjection;

use l3l0\Bundle\OpenSocialBundle\DependencyInjection\l3l0OpenSocialExtension;

class l3l0OpenSocialExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testThatDefaultValuesAreSet()
    {
        $containerMock = $this->getContainerMock();

        $containerMock->expects($this->exactly(2))
            ->method('setParameter')
            ->with($this->logicalOr(
                    $this->equalTo('l3l0_open_social.provider.type'),
                    $this->equalTo('l3l0_open_social.storage.type')
                ),
                $this->logicalOr(
                    $this->equalTo('FriendConnectProvider'), 
                    $this->equalTo('FileStorage')
                )
            );

        $config = array(
            'l3l0_open_social' => array(
                'site_id' => 'someSiteId'
            )
        );

        $extension = new l3l0OpenSocialExtension();
        $extension->load($config, $containerMock);
    }

    public function testThatSiteIdIsRequired()
    {
        $extension = new l3l0OpenSocialExtension();

        try {
            $extension->load(array('l3l0_open_social' => array()), $this->getContainerMock());
        }
        catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), 'The child node "site_id" at path "l3l0_open_social" must be configured.');
        }
    }

    public function testThatCanSetClassNames()
    {
        $containerMock = $this->getContainerMock();

        $containerMock->expects($this->exactly(2))
            ->method('setParameter')
            ->with($this->logicalOr(
                    $this->equalTo('l3l0_open_social.provider.type'),
                    $this->equalTo('l3l0_open_social.storage.type')
                ),
                $this->logicalOr(
                    $this->equalTo('myOsapiProvider'), 
                    $this->equalTo('myOsapiStorage')
                )
            );

        $config = array(
            'l3l0_open_social' => array(
                'site_id' => 'someSiteId',
                'types' => array(
                    'provider' => 'myOsapiProvider',
                    'storage'  => 'myOsapiStorage',
                )
            )
        );

        $extension = new l3l0OpenSocialExtension();
        $extension->load($config, $containerMock);
    }

    private function getContainerMock()
    {
        $containerMock = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
           ->disableOriginalConstructor()
           ->getMock();

        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
            ->disableOriginalConstructor()
            ->getMock();
        $parameterBag->expects($this->any())
            ->method('add');

        $containerMock->expects($this->any())
            ->method('getParameterBag')
            ->will($this->returnValue($parameterBag));

        return $containerMock;
    }
}
