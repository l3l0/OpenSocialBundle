<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\Factory\Storage;

use l3l0\Bundle\OpenSocialBundle\Factory\Storage\MemcacheStorageFactory;

class MemcacheStorageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\osapiMemcacheStorage')) {
            $this->markTestSkipped('osapiMemcacheStorage is not loaded');
        }

        if (!function_exists('memcache_connect')) {
            $this->markTestSkipped('Memcache functions not available');
        }
    }

    public function testThatCanCreateStorage()
    {
        $storageFactory = new MemcacheStorageFactory();

        $this->assertInstanceOf('\osapiMemcacheStorage', $storageFactory->create(array()));
    }
}
