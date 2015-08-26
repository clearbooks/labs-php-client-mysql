<?php
namespace Clearbooks\Labs;

class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function WhenRetrievingInstanceOfBootstrap_ObjectIsReturned()
    {
        $this->assertNotNull( Bootstrap::getInstance() );
    }

    /**
     * @test
     */
    public function WhenRetrievingInstanceOfBootstrapTwice_ReturnedObjectsAreTheSame()
    {
        $bootstrap1 = Bootstrap::getInstance();
        $bootstrap2 = Bootstrap::getInstance();
        $this->assertTrue( $bootstrap1 === $bootstrap2 );
    }
}
