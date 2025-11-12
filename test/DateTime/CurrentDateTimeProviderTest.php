<?php
namespace Clearbooks\Labs\DateTime;

use Clearbooks\Labs\LabsTest;

class CurrentDateTimeProviderTest extends LabsTest
{
    private CurrentDateTimeProvider $currentDateTimeProvider;

    public function setUp(): void
    {
        parent::setUp();
        $this->currentDateTimeProvider = new CurrentDateTimeProvider();
    }

    /**
     * @test
     */
    public function WhenRetrievingDateTime_ReturnsCurrentDateTime()
    {
        $this->assertEquals(
            (new \DateTime())->format( "Y-m-d H:i:s" ),
            $this->currentDateTimeProvider->getDateTime()->format( "Y-m-d H:i:s" )
        );
    }
}
