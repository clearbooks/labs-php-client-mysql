<?php
namespace Clearbooks\Labs\Db\Table;

class StringifyableTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function WhenConvertingTableObjectToString_ReturnedStringMatchesTheResultOfGetName()
    {
        $table = new DummyStringifyableTable();
        $this->assertEquals( $table->getName(), (string)$table );
    }
}
