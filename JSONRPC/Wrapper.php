<?php

namespace MMC\XBMCBundle\API\XBMC\JSONRPC;

/**
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

    }
}

?>
