<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/../../../../opensocial-php-client/src/osapi');
require_once "osapi.php";

require_once $_SERVER['SYMFONY'] . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('Symfony', $_SERVER['SYMFONY']);
$loader->register();

spl_autoload_register(function($class)
{
    if (0 === strpos($class, 'l3l0\\Bundle\\OpenSocialBundle\\')) {
        $path = implode('/', array_slice(explode('\\', $class), 2)) . '.php';

        if (file_exists(__DIR__ . '/../../' . $path))
        {
            require_once __DIR__ . '/../../' . $path;

            return true;
        }
    }
});
