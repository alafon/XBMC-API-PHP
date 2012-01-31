<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries;

/**
 * @property \MMC\XBMCBundle\API\XBMC\Server XBMCServer
 * @property array $availableMethods
 */
class APINamespace
{
    /**
     * @var \MMC\XBMCBundle\API\XBMC\Server
     */
    private $XBMCServer;

    public function __construct( \MMC\XBMCBundle\API\XBMC\Server $xbmcServer )
    {
        $this->XBCMServer = $xbmcServer;
        $calledClass = get_called_class();

        foreach ( $this->availableMethods as $availableMethod )
        {
            $methodClass = $calledClass . "\\" . $availableMethod;
            // $methodClass looks like MMC\XBMCBundle\API\XBMC\Libraries\AudioLibrary\Clean

            $this->$availableMethod = new $methodClass( $this->XBCMServer );
        }
    }
}

?>
