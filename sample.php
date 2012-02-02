<?php

use \XBMC\Server as XBMCServer;
use \XBMC\XBMC as XBMC;

require_once 'autoload.php';

$xbmcServer = new XBMCServer( '192.168.0.61' );
$xbmc = new XBMC( $xbmcServer );

var_dump( $xbmc->Wrapper
        ->AudioLibrary
        ->GetAlbums
        ->call( array( 'limits' => array( 'start' => 0, 'end' => 10 ) )) );


