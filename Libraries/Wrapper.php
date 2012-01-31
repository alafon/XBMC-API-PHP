<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries;

/**
 * @property \MMC\XBMCBundle\API\XBMC\Server XBMCServer
 * @property JSONRPC JSONRPC
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
