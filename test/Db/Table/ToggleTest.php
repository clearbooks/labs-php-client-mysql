<?php
namespace Clearbooks\Labs\Db\Table;

class ToggleTest extends TableTest
{
    /**
     * @test
     */
    public function WhenCallingGetName_ExistingTableNameIsReturned()
    {
        $table = new Toggle();
        $this->assertTableExists( $table->getName() );
    }
}
