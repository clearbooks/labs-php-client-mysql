<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Service\ToggleStorage;
use Clearbooks\Labs\LabsTest;

class ToggleGateWayTest extends LabsTest
{
    /**
     * @var ToggleStorage
     */
    private $toggleStorage;

    /**
     * @var ToggleGateway
     */
    private $toggleGateway;

    public function setUp()
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( 'Clearbooks\Labs\Db\Service\ToggleStorage' );

        $this->toggleGateway = Bootstrap::getInstance()->getDIContainer()
                                        ->get( 'Clearbooks\Labs\Toggle\ToggleGateway' );
    }

    /**
     * @test
     */
    public function GivenInvisibleToggle_WhenCallingIsToggleVisibleForUser_ReturnsFalse()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setVisible( false );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );
        $this->assertFalse( $this->toggleGateway->isToggleVisibleForUsers( $toggleId ) );
    }

    /**
     * @test
     */
    public function GivenVisibleToggle_WhenCallingIsToggleVisibleForUser_ReturnsTrue()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setVisible( true );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );
        $this->assertTrue( $this->toggleGateway->isToggleVisibleForUsers( $toggleId ) );
    }
}