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
    array('tar.gz', 'opensocial-php-client', 'http://opensocial-php-client.googlecode.com/files/opensocial-php-client-1.1.1.tar.gz', '1.1.1'),
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
    } elseif ($scm == 'tar.gz') {
        system(sprintf('rm -fr %s', escapeshellarg($installDir)));
        system(sprintf('cd %s; wget %s', escapeshellarg($vendorDir),  escapeshellarg($url)));
        system(sprintf('cd %s; tar xzvf %s-%s.tar.gz', escapeshellarg($vendorDir),  escapeshellarg($name), escapeshellarg($rev)));
        system(sprintf('cd %s; rm %s-%s.tar.gz', escapeshellarg($vendorDir),  escapeshellarg($name), escapeshellarg($rev)));
    }
}
