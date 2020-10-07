<?php
namespace Clearbooks\Labs\Db\Entity;

use PHPUnit\Framework\TestCase;

class ReleaseTest extends TestCase
{
    /**
     * @test
     */
    public function WhenSettingReleaseVisibilityToVisible_ValueInTheArrayProvidedByToArrayWillBeOne()
    {
        $release = new Release();
        $release->setVisibility( true );

        $data = $release->toArray();
        $this->assertEquals( 1, $data["visibility"] );
    }

    /**
     * @test
     */
    public function WhenSettingToggleVisibilityToInvisible_ValueInTheArrayProvidedByToArrayWillBeZero()
    {
        $release = new Release();
        $release->setVisibility( false );

        $data = $release->toArray();
        $this->assertEquals( 0, $data["visibility"] );
    }

    /**
     * @test
     */
    public function GivenInputDataForVisibilityFieldEqualsZero_WhenGettingToggleVisibility_ReturnsFalse()
    {
        $release = new Release( [ "visibility" => 0 ] );
        $this->assertFalse( $release->getVisibility() );
    }

    /**
     * @test
     */
    public function GivenInputDataForVisibilityFieldEqualsOne_WhenGettingToggleVisibility_ReturnsTrue()
    {
        $release = new Release( [ "visibility" => 1 ] );
        $this->assertTrue( $release->getVisibility() );
    }

    /**
     * @test
     */
    public function WhenSettingReleaseDate_ValueInTheArrayProvidedByToArrayWillBeAStringRepresentation()
    {
        $release = new Release();
        $release->setReleaseDate( new \DateTime( "2015-03-15" ) );

        $data = $release->toArray();
        $this->assertEquals( $release->getReleaseDate()->format( "Y-m-d" ), $data["release_date"] );
    }

    /**
     * @test
     */
    public function GivenInputDataForReleaseDateIsPresent_WhenGettingReleaseDate_ReturnsTheSameDate()
    {
        $date = "2015-05-01";
        $release = new Release( [ "release_date" => $date ] );
        $this->assertEquals( $date, $release->getReleaseDate()->format( "Y-m-d" ) );
    }
}
