## Introduction
===============
This Bundle may provide integration with osapi (OpenSocial API).

## Installation
===============

1. Add bundle to ``vendor`` dir:
    * Using ``deps`` file:

            [l3l0OpenSocialBundle]
                git=git://github.com/l3l0/OpenSocialBundle.git
                target=/bundles/l3l0/Bundle/OpenSocialBundle

    * Run the vendor script:

            ./bin/vendors install

    * Enable autoload in ``app/autoload.php``:

            $loader = new UniversalClassLoader();
            $loader->registerNamespace(array(
                ...
                'l3l0' => __DIR__ . '/../vendor/bundles'
            );

    * Register namespace ``app/AppKernel.php``:

            public function registerBundles()
            {
                $bundles = array(
                    ...
                    'l3l0' => __DIR__ . '/../vendor/bundles'
                );
                ...
                return $bundles;
            }

2. Install osapi library see: http://code.google.com/p/opensocial-php-client/wiki/GettingStarted

    * You can in ``vendor`` directory execute:

             svn export http://opensocial-php-client.googlecode.com/svn/trunk/ opensocial-php-client

    * Register osapi lib by add in ``app/autoload.php`` lines:

            set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../vendor/opensocial-php-client/src/osapi');
            require_once "osapi.php";

## Usage
========

1. Security application configuration:

    * We can enable firewall for friend connect in ``app/config/security.yml``. When user is not signed via friend connectto our site will be redirected to ``/`` page by default:

            security:
                firewalls:
                    friend_connect:
                        pattern: ^/yourpath/pattern$
                        l3l0_osapi: true

    * You can define where user should be redirect when is not authenticated via ``public_path`` option:

            security:
                firewalls:
                    friend_connect:
                        pattern: ^/yourpath/pattern$
                        l3l0_osapi:
                            public_path: /app_dev.php/demo
*TODO*
