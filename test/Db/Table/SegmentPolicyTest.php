<?php
namespace Clearbooks\Labs\Db\Table;

class SegmentPolicyTest extends TableTest
{
    /**
     * @test
     */
    public function WhenCallingGetName_ExistingTableNameIsReturned()
    {
        $table = new SegmentPolicy();
        $this->assertTableExists( $table->getName() );
    }
}
