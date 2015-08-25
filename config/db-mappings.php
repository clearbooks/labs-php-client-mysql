<?php

use Clearbooks\Labs\Db\ConnectionDetails;
use Clearbooks\Labs\Db\DoctrineConnectionProvider;
use Clearbooks\Labs\Db\Mysql\MysqlConnectionDetails;
use Clearbooks\Labs\Db\Service\ToggleStorage;
use Clearbooks\Labs\Toggle\UseCase\GroupPolicyRetriever;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;
use Clearbooks\Labs\Toggle\UseCase\UserPolicyRetriever;
use Doctrine\DBAL\Connection;

return [
        ConnectionDetails::class    => function ( \DI\Container $container ) {
            return new MysqlConnectionDetails(
                    $container->get( "db.host" ),
                    $container->get( "db.port" ),
                    $container->get( "db.name" ),
                    $container->get( "db.user" ),
                    $container->get( "db.password" ),
                    "utf8"
            );
        },
        Connection::class           => function ( \DI\Container $container ) {
            /** @var DoctrineConnectionProvider $connectionProvider */
            $connectionProvider = $container->get( DoctrineConnectionProvider::class );
            return $connectionProvider->getConnection();
        },
        ToggleRetriever::class      => DI\object( ToggleStorage::class ),
        UserPolicyRetriever::class  => DI\object( ToggleStorage::class ),
        GroupPolicyRetriever::class => DI\object( ToggleStorage::class )
];
