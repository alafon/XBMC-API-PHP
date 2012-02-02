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