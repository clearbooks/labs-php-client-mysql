<?php
namespace Clearbooks\Labs;

use Clearbooks\Labs\Db\DbDIDefinitionProvider;

class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function GivenAnUninitializedBootstrapInstance_WhenCallingInit_NoExceptionIsThrown()
    {
        ( new Bootstrap() )->init( [ DbDIDefinitionProvider::class ] );
    }

    /**
     * @test
     */
    public function GivenAnUninitializedBootstrapInstance_WhenCallingInit_DIContainerIsAvailable()
    {
        $bootstrap = new Bootstrap();
        $bootstrap->init( [ DbDIDefinitionProvider::class ] );
        $this->assertNotNull( $bootstrap->getDIContainer() );
    }

    /**
     * @test
     */
    public function GivenAnUninitializedBootstrapInstance_WhenCallingInitTwice_DIContainerIsTheSameInstanceAfterAsBefore()
    {
        $bootstrap = new Bootstrap();
        $bootstrap->init( [ DbDIDefinitionProvider::class ] );
        $container1 = $bootstrap->getDIContainer();
        $bootstrap->init( [ DbDIDefinitionProvider::class ] );
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
