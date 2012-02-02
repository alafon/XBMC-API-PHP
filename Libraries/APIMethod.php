<?php

namespace XBMC\Libraries;

/**
 * Abstract class extended by all the method provided by the API.
 *
 *
 * @property \XBMC\Server $XBMCServer
 */
abstract class APIMethod
{
    /**
     * @var \XBMC\Server
     */
    private $XBMCServer;

    /**
     * Constructor
     *
     * @param \XBMC\Server $xbmcServer
     */
    public function __construct( \XBMC\Server $xbmcServer )
    {
        $this->XBCMServer = $xbmcServer;
    }

    /**
     * Makes the call to the server
     *
     * @param array $params
     * @param string $returnType
     * @return mixed
     */
    public function call( $params = array(), $returnType = \XBMC\Server::RETURN_DEFAULT_TYPE )
    {
        // $methodClass looks like \XBMC\Libraries\AudioLibrary\Clean
        $methodClass = get_called_class();

        // extracts "Clean" and "AudioLibrary"
        $methodClassArray = explode( "\\", $methodClass );
        $method = array_pop($methodClassArray);
        $namespace = array_pop($methodClassArray);

        // finally, make the call to the server using the XBMCServer object
        return $this->XBCMServer->makeCall( "{$namespace}.{$method}", $params, $returnType );
    }
}

?>
