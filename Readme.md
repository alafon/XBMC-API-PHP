# XBMC PHP API

## Status : draft

This project is still under development, changing every day, needing a lot of
documentation, etc, etc. So please, be my guest and get in touch with me.

## Usage

This XBMC API provides a wrapper which is just a simple class container for the
API namespaces and methods. __ BUT __ it helps in getting a great auto-
completion feature (at least working on NetBeans 7.0.1, I need to test it on
other IDEs)

First create a new XBMCServer instance

```php

use \MMC\XBMCBundle\API\XBMC\XBMC as XBMC;
use \MMC\XBMCBundle\API\XBMC\Server as XBMCServer;

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

Example to get the 100st albums of your audio library :

```php
$xbmc->Wrapper
        ->AudioLibrary
        ->GetAlbums
        ->call( array( 'limits' => array( 'start'  => 0,
                                          'end'    => 100 ))) );
```

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

## Notes regarding PHP namespaces

This project is a subproject of another one being developed over Symfony2 so
that's why the namespace I use looks like MMC\XBMCBundle\API\XBMC\...

This should not prevents you from using this API. If it's the case, please let
me know by opening an issue.