# XBMC PHP API

## Status : draft

This project is still under development, changing every day, needing a lot of
documentation, etc, etc. So please, be my guest and get in touch with me.

## Note about autoloads

You can use the autoload.php file so that classes will be included dynamically.
If you use Symfony2, just add XBMC as a namespace prefix in app/autoload.php and
make it linked to the folder where you've cloned this API (in the following case
the API is part of a bundle).

```php

$loader->registerNamespaces(array(
    'Symfony'          => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
    'Sensio'           => __DIR__.'/../vendor/bundles',
    'JMS'              => __DIR__.'/../vendor/bundles',
    'Doctrine\\Common' => __DIR__.'/../vendor/doctrine-common/lib',
    'Doctrine\\DBAL'   => __DIR__.'/../vendor/doctrine-dbal/lib',
    'Doctrine'         => __DIR__.'/../vendor/doctrine/lib',
    'Monolog'          => __DIR__.'/../vendor/monolog/src',
    'Assetic'          => __DIR__.'/../vendor/assetic/src',
    'Metadata'         => __DIR__.'/../vendor/metadata/src',
    'XBMC'         => __DIR__.'/../src/MMC/XBMCBundle/API',
));
```


## Usage

This XBMC API provides a wrapper which is just a simple class container for the
API namespaces and methods. __ BUT __ it helps in getting a great auto-
completion feature (at least working on NetBeans 7.0.1, I need to test it on
other IDEs).

First create a new XBMCServer instance :

```php

use \XBMC\XBMC as XBMC;
use \XBMC\Server as XBMCServer;

$xbmcServer = new XBMCServer( '192.168.0.61' );
$xbmc = new XBMC( $xbmcServer );
```

Then, just call the API using the namespace and method convention defined at
[JSON-RPC API v3](http://wiki.xbmc.org/index.php?title=JSON-RPC_API/v3)

```php
$xbmc->Wrapper
        ->AudioLibrary
        ->GetAlbums
        ->call();
```

`AudioLibray` is the namespace defined within the official XBMC API

`GetAlbums` is one of the method provided by the AudioLibray namespace

`call()` finishes the job (request building and call to your XBMC server)

`call()` can take an associative array of parameters which will be transformed
into JSON before being sent with your query

Example to get the 10st albums of your audio library :

```php
$xbmc->Wrapper
        ->AudioLibrary
        ->GetAlbums
        ->call( array( 'limits' => array( 'start'  => 0,
                                          'end'    => 10 ))) );
```

see sample.php

## XBMC Request and Response

Each request to your XBMC server is accessible by $xbmc->getJSONRequest() once
it has been called.

```php
$xbmc->Wrapper
        ->AudioLibrary
        ->GetAlbums
        ->call( array( 'limits' => array( 'start'  => 0,
                                          'end'    => 10 )));

var_dump( $xbmc->getJSONRequest() );
```

returns

```
string(106) "{"jsonrpc":"2.0","id":1522541,"method":"AudioLibrary.GetAlbums","params":{"limits":{"start":0,"end":10}}}"
```

Same for the response with $xbmc->getJSONRequest()

## XBMC class features

- $xbmc->isAlive() returns true if you server is up
- to be continued

## Extending API Method

You can extend API methods, see Libraries/JSONRPC/Introspect.php for an example.

```php
<?php

namespace XBMC\Libraries\JSONRPC;

use \XBMC\Libraries\APIMethod as APIMethod;
use \XBMC\Server as XBMCServer;

/**
 * A simple definition for JSONRPC.Introspect
 * You can add custom methods in this class (see Introspect.getAPIMethodsList()
 * for an example)
 *
 * Note: this class was auto-generated using JSONRPC.Introspect results
 * @see \XBMC\Libraries\Generator
 *
 */
class Introspect extends APIMethod
{
    public function getAPIMethodsList()
    {
        $introspectArray = $this->call( array(), XBMCServer::RETURN_TYPE_ARRAY );
        return array_keys( $introspectArray['result']['methods'] );
    }
}
```

