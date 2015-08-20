<?php

require_once "../vendor/autoload.php";

$containerBuilder = new \DI\ContainerBuilder();

$containerBuilder->addDefinitions( '../config/mysql-config.php' );
$containerBuilder->addDefinitions( '../config/mappings.php' );

$container = $containerBuilder->build();

/** @var \Clearbooks\Labs\Mysql\Foo $foo */
$foo = $container->get( 'Clearbooks\Labs\Mysql\Foo' );
$foo->doSomething();
