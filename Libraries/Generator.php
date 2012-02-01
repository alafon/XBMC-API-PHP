<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries;

class Generator
{
    private $APINamespace;
    private $APIMethod;

    const RETURN_STATUS_CREATED = 0;
    const RETURN_STATUS_EXISTS = 1;
    const RETURN_STATUS_ERROR = 2;

    public function __construct( $APINamespace, $APIMethod )
    {
        $this->APIMethod = $APIMethod;
        $this->APINamespace = $APINamespace;
    }

    public function getCode()
    {
        $classCode = <<<EOF
<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries\\$this->APINamespace;

use \MMC\XBMCBundle\API\XBMC\Libraries\APIMethod as APIMethod;

/**
 * A simple definition for $this->APINamespace.$this->APIMethod
 * You can add custom methods in this class (see Introspect.getAPIMethodsList()
 * for an example)
 *
 * Note: this class was auto-generated using JSONRPC.Introspect results
 * @see \MMC\XBMCBundle\API\XBMC\Libraries\Generator
 *
 */
class $this->APIMethod extends APIMethod
{
}
EOF;
        return $classCode;
    }

    private function getLocation()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . $this->APINamespace;
    }

    private function getFileName()
    {
        return "{$this->APIMethod}.php";
    }

    public function generateAndWriteToDisk()
    {
        $location = $this->getLocation();
        $filename = $this->getFileName();
        $filepath = $location . DIRECTORY_SEPARATOR . $filename;

        if(file_exists($filepath))
        {
            return self::RETURN_STATUS_EXISTS;
        }

        if( !is_dir($location))
        {
            mkpath( $location );
        }

        if( $fh = fopen( $filepath , 'r+' ) )
        {
            $written = fwrite( $fh, $this->getCode() ) !== false;
            fclose( $fh );
            return $written ? self::RETURN_STATUS_CREATED : self::RETURN_STATUS_ERROR;
        }
        return self::RETURN_STATUS_ERROR;


    }

}

?>
