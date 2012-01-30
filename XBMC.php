<?php

namespace MMC\XBMCBundle\API\XBMC;

/**
 * @property Server XBMCServer
 * @property JSONRPC\JSONRPC JSONRPC
 */
class XBMC
{
    private $XBMCServer;

    public function __construct( Server $xbmcServer )
    {
        $this->setXBMCServer($xbmcServer);
        $this->JSONRPC = new JSONRPC\Wrapper( $xbmcServer );
    }

    private function setXBMCServer( Server $xbmcServer )
    {
        $this->XBMCServer = $xbmcServer->isValid() ? $xbmcServer : null;
    }

    public function getServerParameters()
    {
        return get_object_vars( $this->XBMCServer );
    }
}

?>
