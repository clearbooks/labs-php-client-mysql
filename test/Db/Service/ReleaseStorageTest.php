<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Release;
use Clearbooks\Labs\LabsTest;

class ReleaseStorageTest extends LabsTest
{
    /**
     * @var ReleaseStorage
     */
    private $releaseStorage;

    public function setUp(): void
    {
        parent::setUp();
        $this->releaseStorage = Bootstrap::getInstance()->getDIContainer()
                                         ->get( ReleaseStorage::class );
    }

    /**
     * @test
     */
    public function GivenAReleaseWithPresetId_WhenInsertingRelease_InsertedIdWillMatchTheSpecifiedId()
    {
        $release = new Release();
        $release->setId( 999 );
        $release->setName( "test release" );

        $releaseId = $this->releaseStorage->insertRelease( $release );

        $this->assertEquals( $release->getId(), $releaseId );
    }
    
    /**
     * @test
     */
    public function GivenARelease_WhenRetrievingReleaseById_ReleaseDataReturns()
    {
        $release = new Release();
        $release->setName( "test release" );
        $release->setVisibility( 1 );
        $release->setReleaseDate( new \DateTime( "2015-01-01" ) );
        $release->setInfo( "test info" );

        $releaseId = $this->releaseStorage->insertRelease( $release );

        $retrievedRelease = $this->releaseStorage->getReleaseById( $releaseId );
        $this->assertNotNull( $retrievedRelease );
        $this->assertEquals( $releaseId, $retrievedRelease->getId() );
        $this->assertEquals( $release->getName(), $retrievedRelease->getName() );
        $this->assertEquals( $release->getVisibility(), $retrievedRelease->getVisibility() );
        $this->assertEquals( $release->getReleaseDate(), $retrievedRelease->getReleaseDate() );
        $this->assertEquals( $release->getInfo(), $retrievedRelease->getInfo() );
    }
}
