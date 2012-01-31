<?php

namespace MMC\XBMCBundle\API\XBMC;

/**
 * @property string     $host
 * @property integer    $port
 * @property string     $username
 * @property string     $password
 *
 * @property string $json_request
 * @property string $json_request_id
 * @property json $json_response
 * @property string  $string_response
 */
class Server
{
    const JSON_VERSION = '2.0';
    const JSON_API_URI = '/jsonrpc';

    public function __construct( $host, $port = '8080', $username = 'xbmc', $password = '' )
    {
        $this->host = trim( $host );
        $this->port = $port;
        $this->username = trim( $username );
        $this->password = trim( $password );
    }

    /**
     * Returns true if a couple of tests do not fail
     *
     * @return boolean
     */
    public function isValid()
    {
        $valid = true;
        if( empty( $this->host ) )
        {
            $valid = false;
            throw new exception\Server( "XBMC server domain is empty" );
        }

        return $valid;
    }


    private function buildJsonRequest( $method, $params )
    {
        $this->json_request_id = rand(1,9999999);

        $jsonArray = array( 'jsonrpc' => self::JSON_VERSION,
                            'id' => $this->json_request_id,
                            'method' => $method,
                            'params' => $params );

        $jsonRequest = json_encode($jsonArray);

        return $jsonRequest;
    }

    public function makeCall( $method, $params, $resultAsString = false )
    {

        $this->json_request  = $this->buildJsonRequest( $method, $params );
        $requestURL = "http://" . $this->getHostPort() . self::JSON_API_URI;

        // todo manage curl extension loading status

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $requestURL );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->json_request);

        $this->string_response = curl_exec($ch);
        $this->json_response = json_decode( $this->string_response );

        if( $resultAsString )
        {
            $response = $this->string_response;
        }
        else
        {
            $response = $this->json_response;
        }

        // reset or tag something to know that everything goes right or wring

        return $response;
    }

    /**
     * Returns the host+port if port is a valid integer
     *
     * @return string
     */
    private function getHostPort()
    {
        if( is_integer( $this->port ) )
        {
            return $this->host . ":" . $this->port;
        }
        else
        {
            return $this->host;
        }
    }

}

?>
