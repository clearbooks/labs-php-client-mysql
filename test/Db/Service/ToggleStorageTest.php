<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\LabsTest;

class ToggleStorageTest extends LabsTest
{
    /**
     * @var ToggleStorage
     */
    private $toggleStorage;

    public function setUp()
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( 'Clearbooks\Labs\Db\Service\ToggleStorage' );
    }

    /**
     * @test
     */
    public function GivenAToggle_WhenRetrievingToggle_ToggleDataReturns()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_SIMPLE );
        $toggle->setReleaseId( 1 );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );

        $retrievedToggle = $this->toggleStorage->getToggleById( $toggleId );
        $this->assertNotNull( $retrievedToggle );
        $this->assertEquals( $toggle->getName(), $retrievedToggle->getName() );
        $this->assertEquals( $toggle->getType(), $retrievedToggle->getType() );
        $this->assertEquals( $toggle->isVisible(), $retrievedToggle->isVisible() );
        $this->assertEquals( $toggle->getReleaseId(), $retrievedToggle->getReleaseId() );
    }

    /**
     * @test
     */
    public function GivenAToggleWithPresetId_WhenInsertingToggle_InsertedIdWillMatchTheSpecifiedId()
    {
        $toggle = new Toggle();
        $toggle->setId( 999 );
        $toggle->setName( "test toggle" );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );

        $this->assertEquals( $toggle->getId(), $toggleId );
    }
}