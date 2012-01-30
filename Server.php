<?php

namespace MMC\XBMCBundle\API\XBMC;

/**
 * @property string domain
 * @property integer port
 * @property string username
 * @property string password
 *
 * @property array json_request
 * @property array json_response
 */
class Server
{
    const JSON_VERSION = '3.0';
    const JSON_API_URI = '/jsonrpc';

    public function __construct( $domain, $port = 8080, $username = 'xbmc', $password = '' )
    {
        $this->domain = trim( $domain );
        $this->port = $port;
        $this->username = trim( $username );
        $this->password = trim( $password );
    }

    public function isValid()
    {
        $valid = true;
        if( empty( $this->domain ) )
        {
            $valid = false;
            throw new exception\Server( "XBMC server domain is empty" );
        }

        return $valid;
    }

    private function buildJsonRequest( $method, $params )
    {
        $jsonArray = array( 'jsonrpc' => self::JSON_VERSION,
                            'id' => rand(1,9999999),
                            'method' => $method,
                            'params' => $params );

        $jsonRequest = json_encode($jsonArray);

        return $jsonRequest;
    }

    public function makeCall( $method, $params, $resultsAsArray = false )
    {

        $this->json_request  = $this->buildJsonRequest( $method, $params );
        $requestURL = "http://" . $this->getHostPort() . self::JSON_API_URI;

        // todo manage curl extension loading status

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $requestURL );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->json_request);

        $this->json_response = curl_exec($ch);

        var_dump( $this );

        if( $resultsAsArray )
        {
            $response = json_decode( $this->json_response );
        }
        else
        {
            $response = $this->json_response;
        }
        // reset rpcRequest
    }

    private function getHostPort()
    {
        if( is_integer( $this->port ) )
        {
            return $this->domain . ":" . $this->port;
        }
        else
        {
            return $this->domain;
        }
    }

}

?>
