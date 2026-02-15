<?php
namespace Clearbooks\Labs;

use DI\Container;
use DI\ContainerBuilder;

class Bootstrap
{
    private static ?Bootstrap $instance = null;
    private Container $DIContainer;
    private bool $initialized = false;

    /**
     * @codeCoverageIgnore
     */
    public static function getInstance(): Bootstrap
    {
        if ( self::$instance == null ) {
            self::$instance = new Bootstrap();
        }

        return self::$instance;
    }

    /**
     * Initialization (e.g.: DI container)
     *
     * @param string[] $definitionProviderClasses
     */
    public function init( array $definitionProviderClasses ): void
    {
        if ( $this->initialized ) {
            return;
        }

        $containerBuilder = new ContainerBuilder();

        $this->loadDefinitions( $containerBuilder, $definitionProviderClasses );

        $this->DIContainer = $containerBuilder->build();

        $this->initialized = true;
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param array            $definitionProviderClasses
     */
    private function loadDefinitions( ContainerBuilder $containerBuilder, array $definitionProviderClasses ): void
    {
        foreach ( $definitionProviderClasses as $definitionProviderClass ) {
            /** @var DIDefinitionProvider $definitionProvider */
            $definitionProvider = new $definitionProviderClass;

            $definitionPaths = $definitionProvider->getDefinitionPaths();
            foreach ( $definitionPaths as $definitionPath ) {
                $containerBuilder->addDefinitions( $definitionPath );
            }
        }
    }

    public function getDIContainer(): Container
    {
        return $this->DIContainer;
    }
}
