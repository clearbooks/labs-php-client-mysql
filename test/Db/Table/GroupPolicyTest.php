<?php
namespace Clearbooks\Labs\Db\Table;

class GroupPolicyTest extends TableTest
{
    /**
     * @test
     */
    public function WhenCallingGetName_ExistingTableNameIsReturned()
    {
        $table = new GroupPolicy();
        $this->assertTableExists( $table->getName() );
    }
}
