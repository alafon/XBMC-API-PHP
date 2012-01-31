<?php

namespace MMC\XBMCBundle\API\XBMC;

/**
 * @property Server             $XBMCServer
 * @property JSONRPC\JSONRPC    $JSONRPC
 */
class XBMC
{
    private $XBMCServer;

    public function __construct( Server $xbmcServer )
    {
        $this->setXBMCServer($xbmcServer);
        $this->JSONRPC = new JSONRPC\Wrapper( $xbmcServer );
    }

    public function isAlive()
    {
        return $this->JSONRPC->JSONRPC->Ping->call()->result == 'pong';
    }


    private function setXBMCServer( Server $xbmcServer )
    {
        $this->XBMCServer = $xbmcServer->isValid() ? $xbmcServer : null;
    }

    public function getServerParameters()
    {
        // return get_object_vars( $this->XBMCServer );
        return array( 'host' => $this->XBMCServer->host,
                      'port' => $this->XBMCServer->port,
                      'username' => $this->XBMCServer->username,
                      'password' => $this->XBMCServer->password );
    }
}

?>
