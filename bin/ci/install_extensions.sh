#!/bin/bash

function install_memcache {
    wget http://pecl.php.net/get/memcache-2.2.6.tgz
    tar -xzf memcache-2.2.6.tgz
    sh -c "cd memcache-2.2.6 && phpize && ./configure --enable-memcache && make && sudo make install"
    echo "extension=memcache.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
}

function install_apc {
    wget http://pecl.php.net/get/APC-3.1.9.tgz
    tar -xzf APC-3.1.9.tgz
    sh -c "cd APC-3.1.9 && phpize && ./configure --enable-memcache && make && sudo make install"
    echo "extension=apc.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
}

install_memcache
install_apc
