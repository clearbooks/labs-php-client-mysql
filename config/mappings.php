<?php

use Clearbooks\Labs\Mysql\Connection\ConnectionDetails;
use Clearbooks\Labs\Mysql\Connection\ConnectionProvider;
use Clearbooks\Labs\Mysql\Connection\MysqlConnectionDetails;
use Doctrine\DBAL\Connection;

return [
        ConnectionDetails::class  => function () {
            return new MysqlConnectionDetails(
                    DI\string( "{db.host}" ),
                    DI\string( "{db.port}" ),
                    DI\string( "{db.name}" ),
                    DI\string( "{db.user}" ),
                    DI\string( "{db.password}" ),
                    "UTF-8"
            );
        },
        ConnectionProvider::class => DI\object( 'Clearbooks\Labs\Mysql\Connection\DoctrineConnectionProvider' ),
        Connection::class         => [ DI\get( 'Clearbooks\Labs\Mysql\Connection\ConnectionProvider' ),
                                       'getConnection' ]
];
