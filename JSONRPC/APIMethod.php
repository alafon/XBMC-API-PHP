<?php

namespace MMC\XBMCBundle\API\XBMC\JSONRPC;

class APIMethod
{


    public function __construct( \MMC\XBMCBundle\API\XBMC\Server $xbmcServer )
    {
        $this->XBCMServer = $xbmcServer;
    }

    public function call( $params )
    {
        // $methodClass looks like MMC\XBMCBundle\API\XBMC\JSONRPC\AudioLibrary\Clean
        $methodClass = get_called_class();

        // extracts "Clean"
        $methodClassArray = explode( "\\", $methodClass );
        $method = array_pop($methodClassArray);

        return $this->XBCMServer->makeCall( $method, $params );
    }
}

?>
