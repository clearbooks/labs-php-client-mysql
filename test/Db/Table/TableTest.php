<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\LabsTest;

abstract class TableTest extends LabsTest
{
    /**
     * Asserts that a table exists
     */
    public function assertTableExists( string $tableName ): void
    {
        $schemaManager = $this->connection->getSchemaManager();
        $this->assertTrue( $schemaManager->tablesExist( [ $tableName ] ) );
    }
}
