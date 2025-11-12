<?php
namespace Clearbooks\Labs;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;

abstract class LabsTest extends TestCase
{
    protected Connection $connection;

    public function setUp(): void
    {
        parent::setUp();
        $this->connection = Bootstrap::getInstance()->getDIContainer()
                                     ->get( Connection::class );

        $this->connection->beginTransaction();
        $this->connection->setRollbackOnly();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->connection->rollBack();
    }
}
