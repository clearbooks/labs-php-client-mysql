<?php
namespace Clearbooks\Labs\Db\Table;

class UserPolicyTest extends TableTest
{
    /**
     * @test
     */
    public function WhenCallingGetName_ExistingTableNameIsReturned()
    {
        $table = new UserPolicy();
        $this->assertTableExists( $table->getName() );
    }
}
