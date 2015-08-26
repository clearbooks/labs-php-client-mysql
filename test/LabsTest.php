<?php
namespace Clearbooks\Labs;

use Doctrine\DBAL\Connection;

abstract class LabsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Connection
     */
    protected $connection;

    public function setUp()
    {
        parent::setUp();
        $this->connection = Bootstrap::getInstance()->getDIContainer()
                                     ->get( Connection::class );

        $this->connection->beginTransaction();
        $this->connection->setRollbackOnly();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->connection->rollBack();
    }
}
