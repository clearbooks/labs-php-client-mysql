<?php
namespace Clearbooks\Labs\Db\Table;

class SubscribersTest extends TableTest
{
    /**
     * @test
     */
    public function WhenCallingGetName_ExistingTableNameIsReturned()
    {
        $table = new Subscribers();
        $this->assertTableExists( $table->getName() );
    }
}
