<?php
namespace Clearbooks\Labs;

class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function GivenAnUninitializedBootstrapInstance_WhenCallingInit_NoExceptionIsThrown()
    {
        ( new Bootstrap() )->init();
    }

    /**
     * @test
     */
    public function GivenAnUninitializedBootstrapInstance_WhenCallingInit_DIContainerIsAvailable()
    {
        $bootstrap = new Bootstrap();
        $bootstrap->init();
        $this->assertNotNull( $bootstrap->getDIContainer() );
    }

    /**
     * @test
     */
    public function GivenAnUninitializedBootstrapInstance_WhenCallingInitTwice_DIContainerIsTheSameInstanceAfterAsBefore()
    {
        $bootstrap = new Bootstrap();
        $bootstrap->init();
        $container1 = $bootstrap->getDIContainer();
        $bootstrap->init();
        $container2 = $bootstrap->getDIContainer();
        $this->assertTrue( $container1 === $container2 );
    }

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
