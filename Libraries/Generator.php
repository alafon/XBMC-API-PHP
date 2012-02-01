<?php

namespace MMC\XBMCBundle\API\XBMC\Libraries;

/**
 * This class helps us creating the directory structure and the classes
 * need to have a great auto-completion feature with the XBMC API
 *
 * Usage :
 * $generator = new Generator( 'AudioLibrary', array( 'Clean', '...' ) );
 * $generator->generateAndWriteToDisk();
 *
 * For the moment, these classes are written in
 * app/cache/dev/mmc/XBMC/Libraries
 *
 */
class Generator
{
    private $APINamespace;
    private $APIMethods;

    const RETURN_STATUS_CREATED = 0;
    const RETURN_STATUS_EXISTS = 1;
    const RETURN_STATUS_ERROR = 2;

    /**
     *
     * @param string $APINamespace
     * @param array $APIMethods
     */
    public function __construct( $APINamespace, $APIMethods, $baseLocation = null )
    {
        $this->APIMethods = $APIMethods;
        $this->APINamespace = $APINamespace;

        // @todo make it more sexy...
        $this->baseLocation = $baseLocation == null ? realpath( __DIR__ . "/../../../../../../app/cache/dev" ) . "/mmc/XBMC/Libraries" : $baseLocation;
    }

    /**
     * Generates the code for a APIMethod class
     *
     * @param string $method
     * @return string
     */
    private function getAPIMethodCode( $method )
    {
        $classCode = <<<EOF
<?php

namespace MMC\\XBMCBundle\\API\\XBMC\\Libraries\\$this->APINamespace;

use \\MMC\\XBMCBundle\\API\\XBMC\\Libraries\\APIMethod as APIMethod;

/**
 * A simple definition for $this->APINamespace.$method
 * You can add custom methods in this class (see Introspect.getAPIMethodsList()
 * for an example)
 *
 * Note: this class was auto-generated using JSONRPC.Introspect results
 * @see \\MMC\\XBMCBundle\\API\\XBMC\\Libraries\\Generator
 *
 */
class $method extends APIMethod
{
}
EOF;
        return $classCode;
    }

    /**
     * Generates the code for a APINamespace class
     *
     * @return string
     */
    private function getAPINamespaceCode()
    {
        $classCode = <<<EOF
<?php

namespace MMC\\XBMCBundle\\API\\XBMC\\Libraries;

/**
 * A simple definition for $this->APINamespace
 *
 * Note: this class was auto-generated using JSONRPC.Introspect results
 * @see \\MMC\\XBMCBundle\\API\\XBMC\\Libraries\\Generator
 *
EOF;
        foreach( $this->APIMethods as $method )
        {
            $classCode .= <<<EOF

 * @property $this->APINamespace\\$method    \$$method
EOF;
        }

        $classCode .= <<<EOF

 *
 */
class $this->APINamespace extends APINamespace
{
}
EOF;
        return $classCode;
    }

    public function getLocation()
    {

        return $this->baseLocation;
    }

    private function getMethodFileName( $method )
    {
        return "{$method}.php";
    }

    private function getNamespaceFileName()
    {
        return "{$this->APINamespace}.php";
    }

    /**
     * Generates both APIMethod classes and the main APINamespace class
     */
    public function generateAndWriteToDisk()
    {
        // API Methods for this namespace
        foreach( $this->APIMethods as $method )
        {
            $methodLocation = $this->getLocation() . DIRECTORY_SEPARATOR . $this->APINamespace;
            $methodFilename = $this->getMethodFileName( $method );
            $filepath = $methodLocation . DIRECTORY_SEPARATOR . $methodFilename;

            if( !file_exists( $filepath ))
            {
                if( !is_dir( $methodLocation ))
                {
                    mkdir( $methodLocation, 0777, true );;
                }

                if( $fh = fopen( $filepath , 'w+' ))
                {
                    fwrite( $fh, $this->getAPIMethodCode( $method ) );
                    fclose( $fh );
                }
            }
        }

        // API Namespace
        $namespaceLocation = $this->getLocation();
        $namespaceFilename = $this->getNamespaceFileName();
        $filepath = $namespaceLocation . DIRECTORY_SEPARATOR . $namespaceFilename;

        if( !file_exists( $filepath ))
        {
            if( $fh = fopen( $filepath , 'w+' ))
            {
                fwrite( $fh, $this->getAPINamespaceCode() );
                fclose( $fh );
            }
        }
    }

    static public function APIDefinitionAsArray( $namespacesPlusMethods )
    {
        $namespaces = array();
        foreach( $namespacesPlusMethods as $namespacePlusMethod )
        {
            list( $namespace, $method ) = explode( ".", $namespacePlusMethod );
            $namespaces[$namespace][] = $method;
        }
        return $namespaces;
    }

    static public function getWrapperNamespaceProperties( $namespaces )
    {
        $phpDoc = <<<EOF
EOF;
        foreach( $namespaces as $namespace )
        {
            $phpDoc .= <<<EOF

 * @property $namespace \$$namespace
EOF;
        }
        return $phpDoc;
    }

}

?>
