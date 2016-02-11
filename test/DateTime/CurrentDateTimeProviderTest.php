<?php
namespace Clearbooks\Labs\DateTime;

use Clearbooks\Labs\LabsTest;

class CurrentDateTimeProviderTest extends LabsTest
{
    /**
     * @var CurrentDateTimeProvider
     */
    private $currentDateTimeProvider;

    public function setUp()
    {
        parent::setUp();
        $this->currentDateTimeProvider = new CurrentDateTimeProvider();
    }

    /**
     * @test
     */
    public function WhenRetrievingDateTime_ReturnsCurrentDateTime()
    {
        $this->assertEquals( new \DateTime(), $this->currentDateTimeProvider->getDateTime() );
    }
}
