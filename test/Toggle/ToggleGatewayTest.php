<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\DateTime\StaticDateTimeProvider;
use Clearbooks\Labs\Db\Entity\Release;
use Clearbooks\Labs\Db\Service\ReleaseStorage;
use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Service\ToggleStorage;
use Clearbooks\Labs\LabsTest;
use Clearbooks\Labs\Toggle\UseCase\ReleaseRetriever;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;

class ToggleGatewayTest extends LabsTest
{
    private ToggleStorage $toggleStorage;
    private ReleaseStorage $releaseStorage;
    private ToggleGateway $toggleGateway;
    private StaticDateTimeProvider $dateTimeProvider;

    public function setUp(): void
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( ToggleStorage::class );

        $this->releaseStorage = Bootstrap::getInstance()->getDIContainer()
                                         ->get( ReleaseStorage::class );

        $toggleRetriever = Bootstrap::getInstance()->getDIContainer()
                                    ->get( ToggleRetriever::class );

        $releaseRetriever = Bootstrap::getInstance()->getDIContainer()
                                     ->get( ReleaseRetriever::class );

        $this->dateTimeProvider = new StaticDateTimeProvider();
        $this->toggleGateway = new ToggleGateway( $toggleRetriever, $releaseRetriever, $this->dateTimeProvider );
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

    /**
     * @test
     */
    public function GivenToggleWithoutRelease_WhenCallingIsReleaseDateOfToggleReleaseTodayOrInThePast_ReturnsFalse()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_SIMPLE );

        $this->toggleStorage->insertToggle( $toggle );
        $this->assertFalse( $this->toggleGateway->isReleaseDateOfToggleReleaseTodayOrInThePast( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenToggleWithReleaseButWithoutReleaseDate_WhenCallingIsReleaseDateOfToggleReleaseTodayOrInThePast_ReturnsFalse()
    {
        $toggle = $this->createToggleWithRelease( null );
        $this->assertFalse( $this->toggleGateway->isReleaseDateOfToggleReleaseTodayOrInThePast( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenToggleWithFutureRelease_WhenCallingIsReleaseDateOfToggleReleaseTodayOrInThePast_ReturnsFalse()
    {
        $currentDate = new \DateTime( "2015-01-01" );
        $releaseDate = new \DateTime( "2015-02-01" );
        $this->dateTimeProvider->setDateTime( $currentDate );
        $toggle = $this->createToggleWithRelease( $releaseDate );

        $this->assertFalse( $this->toggleGateway->isReleaseDateOfToggleReleaseTodayOrInThePast( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenToggleWithCurrentDateRelease_WhenCallingIsReleaseDateOfToggleReleaseTodayOrInThePast_ReturnsTrue()
    {
        $currentDate = new \DateTime( "2015-01-01" );
        $releaseDate = clone $currentDate;
        $this->dateTimeProvider->setDateTime( $currentDate );
        $toggle = $this->createToggleWithRelease( $releaseDate );

        $this->assertTrue( $this->toggleGateway->isReleaseDateOfToggleReleaseTodayOrInThePast( $toggle->getName() ) );
    }

    /**
     * @test
     */
    public function GivenToggleWithPastRelease_WhenCallingIsReleaseDateOfToggleReleaseTodayOrInThePast_ReturnsTrue()
    {
        $currentDate = new \DateTime( "2015-01-01" );
        $releaseDate = new \DateTime( "2014-01-01" );
        $this->dateTimeProvider->setDateTime( $currentDate );
        $toggle = $this->createToggleWithRelease( $releaseDate );

        $this->assertTrue( $this->toggleGateway->isReleaseDateOfToggleReleaseTodayOrInThePast( $toggle->getName() ) );
    }

    private function createToggleWithRelease( ?\DateTime $releaseDate ): Toggle
    {
        $release = new Release();
        $release->setName( "test release" );
        $release->setVisibility( true );

        if ( $releaseDate instanceof \DateTime ) {
            $release->setReleaseDate( $releaseDate );
        }

        $releaseId = $this->releaseStorage->insertRelease( $release );

        $toggle = new Toggle();
        $toggle->setName( "test toggle" );
        $toggle->setType( ToggleTable::TYPE_SIMPLE );
        $toggle->setReleaseId( $releaseId );
        $toggleId = $this->toggleStorage->insertToggle( $toggle );
        $toggle->setId( $toggleId );

        return $toggle;
    }
}
