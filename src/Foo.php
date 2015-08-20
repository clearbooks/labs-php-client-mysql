<?php
namespace Clearbooks\Labs\Mysql;

use Doctrine\DBAL\Connection;

class Foo {
    public function __construct( Connection $connection ) {
        var_dump($connection);
    }
}
