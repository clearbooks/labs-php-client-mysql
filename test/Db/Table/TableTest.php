<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\LabsTest;

abstract class TableTest extends LabsTest
{
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
