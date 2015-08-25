<?php
namespace Clearbooks\Labs;

use Clearbooks\Labs\Bootstrap;
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
                                     ->get( 'Doctrine\DBAL\Connection' );

        $this->connection->beginTransaction();
        $this->connection->setRollbackOnly();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->connection->rollBack();
    }
}
