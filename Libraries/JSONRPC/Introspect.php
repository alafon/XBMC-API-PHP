<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries\JSONRPC;

use \MMC\XBMCBundle\API\XBMC\Libraries\APIMethod as APIMethod;
use \MMC\XBMCBundle\API\XBMC\Server as XBMCServer;

class Introspect extends APIMethod
{
    public function getAPIMethodsList()
    {
        $introspectArray = $this->call( array(), XBMCServer::RETURN_TYPE_ARRAY );
        return array_keys( $introspectArray['result']['methods'] );
    }
}

?>
