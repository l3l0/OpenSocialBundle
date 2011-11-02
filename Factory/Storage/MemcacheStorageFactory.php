<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Factory\Storage;

use l3l0\Bundle\OpenSocialBundle\Factory\Storage\FactoryInterface as StorageFactoryInterface;

class MemcacheStorageFactory implements StorageFactoryInterface
{
    public function create($options = array())
    {
        return new \osapiMemcacheStorage(
            isset($options['memcache_host']) ? $options['memcache_host'] : 'localhost',
            isset($options['memcache_port']) ? $options['memcache_port'] : '11211'
        );
    }
}
