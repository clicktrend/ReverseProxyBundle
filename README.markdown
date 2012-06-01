Use your symfony2 application behind a reverse proxy.

Sometimes you need to to run your application behind a reverse proxy. E.g. if
you use a SSL proxy for encrypting the application with SSL and you don't
want to buy new certificates.

This bundle manipulates the request with an event listener. Routes and assets
paths are still working.

Let's say "yourapp" is running under

  http://www.domain.com/app_dev.php/controller/action

you can change to

  https://secure.domain.com/yourapp/app_dev.php/controller/action

Installation
============

  1. Add these repositories to your project's deps:

          [ClicktrendReverseProxyBundle]
              git=git@github.com:clicktrend/ReverseProxyBundle.git
              target=/bundles/Clicktrend/ClicktrendPublicSuffixBundle
              

  2. Add `ReverseProxyBundle` namespace to your autoloader:

          // app/autoload.php
          $loader->registerNamespaces(array(
             'Clicktrend\ReverseProxyBundle' => __DIR__.'/../vendor/bundles',
             // your other namespaces
          );

  3. Add this bundle to your application kernel:

          // app/AppKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Clicktrend\ReverseProxyBundle\ClicktrendReverseProxyBundle(),
                  // ...
              );
          }

  4. Modify your config.yml
          // the new path to your assets must be set
          framework:
              templating:      
                  assets_base_urls: /yourapp

          clicktrend_reverse_proxy:
              base_url: /yourapp

  5. Install vendors:

          $ php bin/vendors install

  6. Modify your Apache virtual host like this: (don't forget to activate 
     Proxy modules)
          
          ProxyRequests Off
          SSLProxyEngine On

          ProxyPass /yourapp/ https://secure.domain.com/
          ProxyPassReverse /yourapp/ https://secure.domain.com/

          <Proxy *>
            Order deny,allow
            Allow from all
          </Proxy>
