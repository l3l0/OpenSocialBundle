<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\Factory\Storage;

use l3l0\Bundle\OpenSocialBundle\Factory\Storage\ApcStorageFactory;

class ApcStorageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\osapiApcStorage')) {
            $this->markTestSkipped('osapiApcStorage is not loaded');
        }

        if (!function_exists('apc_add')) {
            $this->markTestSkipped('Apc functions not available');
        }
    }

    public function testThatCanCreateStorage()
    {
        $storageFactory = new ApcStorageFactory();

        $this->assertInstanceOf('\osapiApcStorage', $storageFactory->create(array()));
    }
}
