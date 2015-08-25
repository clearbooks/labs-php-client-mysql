<?php
namespace Clearbooks\Labs\Db\Entity;

class ToggleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function WhenSettingToggleVisibilityToVisible_ValueInTheArrayProvidedByToArrayWillBeOne()
    {
        $toggle = new Toggle( [ ] );
        $toggle->setVisible( true );

        $data = $toggle->toArray();
        $this->assertEquals( 1, $data["visible"] );
    }

    /**
     * @test
     */
    public function WhenSettingToggleVisibilityToInvisible_ValueInTheArrayProvidedByToArrayWillBeZero()
    {
        $toggle = new Toggle( [ ] );
        $toggle->setVisible( false );

        $data = $toggle->toArray();
        $this->assertEquals( 0, $data["visible"] );
    }

    /**
     * @test
     */
    public function GivenInputDataForVisibleFieldEqualsZero_WhenGettingToggleVisibility_ReturnsFalse()
    {
        $toggle = new Toggle( [ "visible" => 0 ] );
        $this->assertFalse( $toggle->isVisible() );
    }

    /**
     * @test
     */
    public function GivenInputDataForVisibleFieldEqualsOne_WhenGettingToggleVisibility_ReturnsTrue()
    {
        $toggle = new Toggle( [ "visible" => 1 ] );
        $this->assertTrue( $toggle->isVisible() );
    }
}
