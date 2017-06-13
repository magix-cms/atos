<?php
/*$path = 'lib/Sips/';
require_once($path.'ShaComposer/ShaComposer.php');
require_once($path.'ShaComposer/AllParametersShaComposer.php');
require_once($path.'SipsNormalizer.php');
require_once($path.'Passphrase.php');
require_once($path.'PaymentRequest.php');
require_once($path.'PaymentResponse.php');
require_once($path.'SipsCurrency.php');*/
/*set_include_path( __DIR__ . '/lib' . PATH_SEPARATOR .
    get_include_path());

function __autoload($class)
{
    print $class;
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once($path . '.php');
}
<?php*/
namespace Sips;

/**
 * Autoloads Dompdf classes
 *
 * @package Dompdf
 */
class Autoloader
{
    const PREFIX = 'Sips';

    /**
     * Register the autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Autoloader
     *
     * @param string
     */
    public static function autoload($class)
    {
        $prefixLength = strlen(self::PREFIX);
        if (0 === strncmp(self::PREFIX, $class, $prefixLength)) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
            $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . $file . '.php');
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}
?>