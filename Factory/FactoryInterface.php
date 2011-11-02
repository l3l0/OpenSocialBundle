<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Factory;

interface FactoryInterface
{
    /**
     * @return \osapi
     */
    function create($options = array());
}
