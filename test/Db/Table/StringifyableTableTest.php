<?php
namespace Clearbooks\Labs\Db\Table;

use PHPUnit\Framework\TestCase;

class StringifyableTableTest extends TestCase
{
    /**
     * @test
     */
    public function WhenConvertingTableObjectToString_ReturnedStringMatchesTheResultOfGetName()
    {
        $table = new DummyStringifyableTable();
        $this->assertEquals( "`" . $table->getName() . "`", (string)$table );
    }
}
