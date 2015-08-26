<?php
namespace Clearbooks\Labs;

use DI\Container;

final class Bootstrap
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

    /**
     * Empty private constructor, necessary for enforcing singleton pattern
     */
    private function __construct()
    {

    }

    /**
     * @return Bootstrap
     */
    public static function getInstance()
    {
        if ( self::$instance == null ) {
            self::$instance = new Bootstrap();
        }

        return self::$instance;
    }

    /**
     * Initialization (e.g.: DI container)
     */
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
