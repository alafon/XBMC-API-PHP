<?php

namespace MMC\XBMCBundle\API\XBMC\JSONRPC;

/**
 * @property \MMC\XBMCBundle\API\XBMC\Server XBMCServer
 * @property array $availableMethods
 */
class APINamespace
{
    
    public function __construct( \MMC\XBMCBundle\API\XBMC\Server $xbmcServer )
    {
        $this->XBCMServer = $xbmcServer;
        $calledClass = get_called_class();

        foreach ( $this->availableMethods as $availableMethod )
        {
            $methodClass = $calledClass . "\\" . $availableMethod;
            // $methodClass looks like MMC\XBMCBundle\API\XBMC\JSONRPC\AudioLibrary\Clean

            $this->$availableMethod = new $methodClass( $this->XBCMServer );
        }
    }
}

?>
