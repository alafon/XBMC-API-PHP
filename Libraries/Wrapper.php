<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries;

/**
 * A container class
 *
 * @property \MMC\XBMCBundle\API\XBMC\Server XBMCServer
 * @property JSONRPC $JSONRPC
 */
class Wrapper
{
    /**
     * Constructor
     *
     * @param \MMC\XBMCBundle\API\XBMC\Server $xbmcServer
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
