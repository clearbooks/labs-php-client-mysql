<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Release;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\LabsTest;

class ToggleStorageTest extends LabsTest
{
    /**
     * @var ToggleStorage
     */
    private $toggleStorage;

    /**
     * @var ReleaseStorage
     */
    private $releaseStorage;

    public function setUp()
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( ToggleStorage::class );

        $this->releaseStorage = Bootstrap::getInstance()->getDIContainer()
                                         ->get( ReleaseStorage::class );
    }

    /**
     * @test
     */
    public function GivenAToggle_WhenRetrievingToggleById_ToggleDataReturns()
    {
        $release = new Release();
        $release->setName( "test release" );
        $releaseId = $this->releaseStorage->insertRelease( $release );

        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_SIMPLE );
        $toggle->setReleaseId( $releaseId );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );

        $retrievedToggle = $this->toggleStorage->getToggleById( $toggleId );
        $this->assertNotNull( $retrievedToggle );
        $this->assertEquals( $toggleId, $retrievedToggle->getId() );
        $this->assertEquals( $toggle->getName(), $retrievedToggle->getName() );
        $this->assertEquals( $toggle->getType(), $retrievedToggle->getType() );
        $this->assertEquals( $toggle->isVisible(), $retrievedToggle->isVisible() );
        $this->assertEquals( $toggle->getReleaseId(), $retrievedToggle->getReleaseId() );
    }

    /**
     * @test
     */
    public function GivenAToggle_WhenRetrievingToggleByName_ToggleDataReturns()
    {
        $release = new Release();
        $release->setName( "test release" );
        $releaseId = $this->releaseStorage->insertRelease( $release );

        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_SIMPLE );
        $toggle->setReleaseId( $releaseId );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );

        $retrievedToggle = $this->toggleStorage->getToggleByName( $toggle->getName() );
        $this->assertNotNull( $retrievedToggle );
        $this->assertEquals( $toggleId, $retrievedToggle->getId() );
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
