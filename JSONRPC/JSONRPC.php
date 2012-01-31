<?php

namespace MMC\XBMCBundle\API\XBMC\JSONRPC;

/**
 * @property JSONRPC\Version    $Version
 * @property JSONRPC\Introspect $Introspect
 * @property JSONRPC\Ping       $Ping
 * @property array $availableMethods
 */
class JSONRPC extends APINamespace
{
    public $availableMethods = array( 'Version',
                                      'Introspect',
                                      'Ping' );
}

?>
