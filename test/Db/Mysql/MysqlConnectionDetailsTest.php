<?php
namespace Clearbooks\Labs\Db\Mysql;

use PHPUnit\Framework\TestCase;

class MysqlConnectionDetailsTest extends TestCase
{
    /**
     * @test
     */
    public function WhenCreatingAConnectionDetailsObject_CorrectValuesCanBeRetrieved()
    {
        $host = "localhost";
        $port = 3306;
        $databaseName = "test";
        $user = "testUser";
        $password = "testPassword";
        $charset = "utf8";

        $connectionDetails = new MysqlConnectionDetails( $host, $port, $databaseName, $user, $password, $charset );

        $this->assertEquals( $host, $connectionDetails->getHost() );
        $this->assertEquals( $port, $connectionDetails->getPort() );
        $this->assertEquals( $databaseName, $connectionDetails->getDatabaseName() );
        $this->assertEquals( $user, $connectionDetails->getUser() );
        $this->assertEquals( $password, $connectionDetails->getPassword() );
        $this->assertEquals( $charset, $connectionDetails->getCharset() );
        $this->assertEquals( "pdo_mysql", $connectionDetails->getDriver() );
    }
}
