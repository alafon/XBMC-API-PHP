<?php

namespace MMC\XBMCBundle\API\XBMC;

/**
 * @property string     $host
 * @property integer    $port
 * @property string     $username
 * @property string     $password
 * @property string     $return_type
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

    const RETURN_DEFAULT_TYPE = 'json';

    const RETURN_TYPE_JSON = 'json';
    const RETURN_TYPE_STRING = 'string';
    const RETURN_TYPE_ARRAY = 'array';

    public function __construct( $host, $port = '8080', $username = 'xbmc', $password = '', $returnType = self::RETURN_DEFAULT_TYPE )
    {
        $this->host = trim( $host );
        $this->port = $port;
        $this->username = trim( $username );
        $this->password = trim( $password );
        $this->return_type = $returnType;
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

    public function makeCall( $method, $params, $returnType = self::RETURN_DEFAULT_TYPE )
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

        switch ( $returnType )
        {
            case self::RETURN_TYPE_ARRAY:
                $response = json_decode( $this->string_response, true );
                break;
            case self::RETURN_TYPE_JSON:
                $response = json_decode( $this->string_response );
                break;
            case self::RETURN_TYPE_STRING:
                $response = $this->string_response;
                break;
            default:
                throw new \Exception( "Unknown return type {$returnType} in " . __CLASS__ );
                break;
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
