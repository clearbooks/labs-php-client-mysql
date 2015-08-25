<?php
namespace Clearbooks\Labs;

use DI\Container;

require_once __DIR__ . "/../vendor/autoload.php";

class Bootstrap
{
    /**
     * @var Bootstrap
     */
    private static $instance = null;

    /**
     * @var Container
     */
    private $DIContainer;

    /**
     * @var bool
     */
    private $initialized = false;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if ( self::$instance == null ) {
            self::$instance = new Bootstrap();
        }

        return self::$instance;
    }

    public function init()
    {
        if ( $this->initialized ) {
            return;
        }

        $containerBuilder = new \DI\ContainerBuilder();

        $containerBuilder->addDefinitions( __DIR__ . '/../config/db-config.php' );
        $containerBuilder->addDefinitions( __DIR__ . '/../config/db-mappings.php' );

        $this->DIContainer = $containerBuilder->build();

        $this->initialized = true;
    }

    /**
     * @return Container
     */
    public function getDIContainer()
    {
        return $this->DIContainer;
    }
}
