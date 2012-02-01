<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries;

/**
 * A container class
 *
 * @property \MMC\XBMCBundle\API\XBMC\Server $XBMCServer
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
    }


    public function __get( $key )
    {
        if( isset( $this->$key ))
        {
            return $this->$key;
        }
        elseif( class_exists( __NAMESPACE__ . "\\{$key}" ) )
        {
            $classname = __NAMESPACE__ . "\\{$key}";
            // new $key() does not take the namespace in account (looks like a php bug)
            $object = new $classname( $this->XBMCServer );
            if( is_subclass_of( $object, __NAMESPACE__ ."\\APINamespace" ) )
            {
                $this->$key = $object;
                return $this->$key;
            }
        }
        throw new \Exception( "{$key} is not accessible in " . __CLASS__ . " or is not a valid API Namespace" );
    }
}

?>
