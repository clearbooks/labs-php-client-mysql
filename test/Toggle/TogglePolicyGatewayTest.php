<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Service\ToggleStorage;
use Clearbooks\Labs\LabsTest;

abstract class TogglePolicyGatewayTest extends LabsTest
{
    /**
     * @var ToggleStorage
     */
    protected $toggleStorage;

    public function setUp()
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( ToggleStorage::class );
    }

    /**
     * @return Toggle
     */
    protected function createTestToggle()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle " . rand( 1, 9999 ) );

        $toggleId = $this->toggleStorage->insertToggle( $toggle );
        $toggle->setId( $toggleId );

        return $toggle;
    }
}
