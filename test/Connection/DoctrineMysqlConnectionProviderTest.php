<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/08/15
 * Time: 14:48
 */

namespace Clearbooks\Labs\Mysql\Connection;


class DoctrineMysqlConnectionProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function givenNoConnectionDetails_getConnectionThrowsInvalidConnectionDetailsException()
    {
        $connectionProvider = new DoctrineConnectionProvider( new DummyConnectionDetails() );
        try {
            $connectionProvider->getConnection();
        } catch ( InvalidConnectionDetailsException $e ) {
            $this->assertTrue( true );
        }
    }

    /**
     * @test
     */
    public function givenConnectionDetailsButCantConnect_getConnectionThrowsCannotConnectToDatabaseException()
    {
        $connectionProvider = new DoctrineConnectionProvider( new StubIncorrectConnectionDetails() );
        try {
            $connectionProvider->getConnection();
        } catch ( CannotConnectToDatabaseException $e ) {
            $this->assertTrue( true );
        }
    }

    /**
     * @test
     */
    public function givenCorrectConnectionDetail_andCanConnect_getConnectionReturnsConnection()
    {
        $connectionProvider = new DoctrineConnectionProvider( new CorrectConnectionDetails() );
        $connecton = $connectionProvider->getConnection();
        $this->assertInstanceOf( '\Doctrine\DBAL\Connection', $connecton );
    }
}