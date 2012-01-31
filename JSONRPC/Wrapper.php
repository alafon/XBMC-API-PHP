<?php

namespace MMC\XBMCBundle\API\XBMC\JSONRPC;

/**
 * @property JSONRPC JSONRPC
 * @property \MMC\XBMCBundle\API\XBMC\Server XBMCServer
 */
class Wrapper
{
    /**
     * @return Wrapper
     */
    public function __construct( \MMC\XBMCBundle\API\XBMC\Server $xbmcServer )
    {
        $this->XBMCServer = $xbmcServer;

        // todo instanciate only when needed via __get override
        $this->JSONRPC = new JSONRPC( $xbmcServer );
    }
}

?>
