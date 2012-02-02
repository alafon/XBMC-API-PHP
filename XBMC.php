<?php

namespace XBMC;

/**
 * @property Server             $XBMCServer
 * @property Libraries\Wrapper  $Wrapper
 */
class XBMC
{
    /**
     * @var \XBMC\Libraries\Wrapper
     */
    public $Wrapper;

    /**
     * @var \XBMC\Server
     */
    private $XBMCServer;

    public function __construct( Server $xbmcServer )
    {
        $this->setXBMCServer($xbmcServer);
        $this->Wrapper = new Libraries\Wrapper( $xbmcServer );
    }

    public function isAlive()
    {
        return $this->Wrapper->JSONRPC->Ping->call()->result == 'pong';
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

    public function getResults( $asString = false )
    {
        return $asString ? $this->XBMCServer->string_response : $this->getJSONResponse();
    }

    public function getJSONResponse()
    {
        return $this->XBMCServer->json_response;
    }

    public function getJSONRequest()
    {
        return $this->XBMCServer->json_request;
    }
}

?>
