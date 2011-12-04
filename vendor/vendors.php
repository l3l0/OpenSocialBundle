#!/usr/bin/env php
<?php

/*
 * This file is part of the OpenSocialBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * File based at similar file from FOSFacebookBundle see <http://friendsofsymfony.github.com/>
 */
set_time_limit(0);

$vendorDir = __DIR__;
$deps = array(
    array('git', 'symfony', 'http://github.com/symfony/symfony', isset($_SERVER['SYMFONY_VERSION']) ? $_SERVER['SYMFONY_VERSION'] : 'origin/master'),
    array('svn', 'opensocial-php-client', 'http://opensocial-php-client.googlecode.com/svn/trunk', ''),
);

foreach ($deps as $dep) {
    list($scm, $name, $url, $rev) = $dep;

    echo "> Installing/Updating $name\n";

    $installDir = $vendorDir.'/'.$name;
    if (!is_dir($installDir)) {
        if ($scm == 'git') {
            system(sprintf('git clone -q %s %s', escapeshellarg($url), escapeshellarg($installDir)));
        }
    }

    if ($scm == 'git') {
        system(sprintf('cd %s && git fetch -q origin && git reset --hard %s', escapeshellarg($installDir), escapeshellarg($rev)));
    } elseif ($scm == 'svn') {
        system(sprintf('svn export --force %s %s', escapeshellarg($url), escapeshellarg($installDir)));
    }
}
