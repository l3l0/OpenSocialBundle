<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\Factory;

use l3l0\Bundle\OpenSocialBundle\Factory\OsapiFactory;

class OsapiFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\osapi')) {
            $this->markTestSkipped('Osapi is not loaded');
        }
    }

    public function testThatCanCreateWithNetlogProvider()
    {
        $factory = new OsapiFactory('NetlogProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => '605776b05bad192d854121de477238a7',
            'consumer_secret' => 'b63bf18647211c8fd7155331c0daedd3e'
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    public function testThatCanCreateWithHi5Provider() {
        $factory = new OsapiFactory('Hi5Provider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => '605776b05bad192d854121de477238a7',
            'consumer_secret' => 'b63bf18647211c8fd7155331c0daedd3e'
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    public function testThatCanCreateWithPartuzaProvider()
    {
        $factory = new OsapiFactory('PartuzaProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => '605776b05bad192d854121de477238a7',
            'consumer_secret' => 'b63bf18647211c8fd7155331c0daedd3e'
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    public function testThatCanCreateWithPlaxoProvider()
    {
        $factory = new OsapiFactory('PlaxoProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => 'anonymous',
            'consumer_secret' => ''
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    public function testThatCanCreateWithOrkutProvider()
    {
        $factory = new OsapiFactory('OrkutProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => 'orkut.com:623061448914',
            'consumer_secret' => 'uynAeXiWTisflWX99KU1D2q5'
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    public function testThatCanCreateWithMyspaceProvider()
    {
        $factory = new OsapiFactory('MyspaceProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => 'http://www.myspace.com/495182150',
            'consumer_secret' => '20ab52223e684594a8050a8bfd4b06693ba9c9183ee24e1987be87746b1b03f8'
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    public function testThatCanCreateWithFriendConnectProvider()
    {
        $factory = new OsapiFactory('FriendConnectProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'fcauth' => 'someFcAuthCookieKey'
        ));

        $this->assertInstanceOf('osapi', $osapi);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithOauth3WithoutConsumerKey()
    {
        $factory = new OsapiFactory('Hi5Provider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_secret' => 'b63bf18647211c8fd7155331c0daedd3e'
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithOauth3WithoutConsumerSecret()
    {
        $factory = new OsapiFactory('Hi5Provider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => '605776b05bad192d854121de477238a7'
        ));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithOauth2WithoutConsumerKey()
    {
        $factory = new OsapiFactory('MyspaceProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_secret' => 'b63bf18647211c8fd7155331c0daedd3e'
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithOauth2WithoutConsumerSecret()
    {
        $factory = new OsapiFactory('MyspaceProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => '605776b05bad192d854121de477238a7'
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithInvalidProviderName()
    {
        $factory = new OsapiFactory('NotExistsProvider', 'FileStorage');

        $osapi = $factory->create(array(
            'consumer_key' => 'http://www.myspace.com/495182150',
            'consumer_secret' => '20ab52223e684594a8050a8bfd4b06693ba9c9183ee24e1987be87746b1b03f8'
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithInvalidStorageName()
    {
        $factory = new OsapiFactory('MyspaceProvider', 'InvalidStorage');

        $osapi = $factory->create(array(
            'consumer_key' => 'http://www.myspace.com/495182150',
            'consumer_secret' => '20ab52223e684594a8050a8bfd4b06693ba9c9183ee24e1987be87746b1b03f8'
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatCannotCreateWithFcAuthWithoutFcAuthKey()
    {
        $factory = new OsapiFactory('FriendConnectProvider', 'FileStorage');

        $osapi = $factory->create(array());
    }
}
