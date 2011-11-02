<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\Factory\Storage;

use l3l0\Bundle\OpenSocialBundle\Factory\Storage\FileStorageFactory;

class FileStorageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\osapiFileStorage')) {
            $this->markTestSkipped('osapiFileStorage is not loaded');
        }
    }

    public function testThatCanCreateStorage()
    {
        $storageFactory = new FileStorageFactory();

        $this->assertInstanceOf('\osapiFileStorage', $storageFactory->create(array()));
    }
}
