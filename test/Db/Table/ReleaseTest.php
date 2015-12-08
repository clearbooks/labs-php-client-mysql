<?php
namespace Clearbooks\Labs\Db\Table;

class ReleaseTest extends TableTest
{
    /**
     * @test
     */
    public function WhenCallingGetName_ExistingTableNameIsReturned()
    {
        $table = new Release();
        $this->assertTableExists( $table->getName() );
    }
}
