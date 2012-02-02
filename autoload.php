<?php

function __autoload( $classname )
{
    $classnameExplode = explode( "\\", $classname );
    $location = implode( "/", array_slice( $classnameExplode, 1) );
    include "{$location}.php";
}