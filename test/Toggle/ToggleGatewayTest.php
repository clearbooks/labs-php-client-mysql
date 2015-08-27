<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
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
                                        ->get( ToggleStorage::class );

        $this->toggleGateway = Bootstrap::getInstance()->getDIContainer()
                                        ->get( ToggleGateway::class );
    }

    /**
     * @test
     */
    public function GivenInvisibleToggle_WhenCallingIsToggleVisibleForUser_ReturnsFalse()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setVisible( false );

        $this->toggleStorage->insertToggle( $toggle );
        $this->assertFalse( $this->toggleGateway->isToggleVisibleForUsers( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenVisibleToggle_WhenCallingIsToggleVisibleForUser_ReturnsTrue()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setVisible( true );

        $this->toggleStorage->insertToggle( $toggle );
        $this->assertTrue( $this->toggleGateway->isToggleVisibleForUsers( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenSimpleToggle_WhenCallingIsGroupToggle_ReturnsFalse()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_SIMPLE );

        $this->toggleStorage->insertToggle( $toggle );
        $this->assertFalse( $this->toggleGateway->isGroupToggle( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenGroupToggle_WhenCallingIsGroupToggle_ReturnsTrue()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_GROUP );

        $this->toggleStorage->insertToggle( $toggle );
        $this->assertTrue( $this->toggleGateway->isGroupToggle( $toggle->getName() ) );
    }
}
