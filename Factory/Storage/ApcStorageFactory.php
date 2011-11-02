<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Factory\Storage;

use l3l0\Bundle\OpenSocialBundle\Factory\Storage\FactoryInterface as StorageFactoryInterface;

class ApcStorageFactory implements StorageFactoryInterface
{
    public function create($options = array())
    {
        return new \osapiApcStorage();
    }
}
