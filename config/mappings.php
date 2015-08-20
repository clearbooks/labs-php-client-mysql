<?php

use Clearbooks\Labs\Mysql\Connection\EntityManagerProvider;
use Clearbooks\Labs\Mysql\Connection\ConnectionDetails;
use Clearbooks\Labs\Mysql\Connection\DoctrineConnectionProvider;
use Clearbooks\Labs\Mysql\Connection\MysqlConnectionDetails;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

return [
        ConnectionDetails::class => function ( \DI\Container $container ) {
            return new MysqlConnectionDetails(
                    $container->get( "db.host" ),
                    $container->get( "db.port" ),
                    $container->get( "db.name" ),
                    $container->get( "db.user" ),
                    $container->get( "db.password" ),
                    "utf8"
            );
        },
        Connection::class        => function ( \DI\Container $container ) {
            /** @var DoctrineConnectionProvider $connectionProvider */
            $connectionProvider = $container->get( DoctrineConnectionProvider::class );
            return $connectionProvider->getConnection();
        },
        EntityManager::class     => function ( \DI\Container $container ) {
            /** @var EntityManagerProvider $entityManagerProvider */
            $entityManagerProvider = $container->get( EntityManagerProvider::class );
            return $entityManagerProvider->getEntityManager();
        }
];
