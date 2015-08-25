<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Bootstrap;
use Doctrine\DBAL\Connection;

abstract class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Connection
     */
    private $connection;

    public function setUp()
    {
        parent::setUp();
        $this->connection = Bootstrap::getInstance()->getDIContainer()
                                     ->get( 'Doctrine\DBAL\Connection' );
    }

    /**
     * Asserts that a table exists
     *
     * @param string $tableName
     */
    public function assertTableExists( $tableName )
    {
        $schemaManager = $this->connection->getSchemaManager();
        $this->assertTrue( $schemaManager->tablesExist( [ $tableName ] ) );
    }
}
