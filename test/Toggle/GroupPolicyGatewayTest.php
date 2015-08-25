<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Service\ToggleStorage;
use Clearbooks\Labs\LabsTest;
use Clearbooks\Labs\Toggle\Entity\GroupStub;

class GroupPolicyGatewayTest extends LabsTest
{
    /**
     * @var ToggleStorage
     */
    private $toggleStorage;

    /**
     * @var GroupPolicyGateway
     */
    private $groupPolicyGateway;

    public function setUp()
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( 'Clearbooks\Labs\Db\Service\ToggleStorage' );

        $this->groupPolicyGateway = Bootstrap::getInstance()->getDIContainer()
                                            ->get( 'Clearbooks\Labs\Toggle\GroupPolicyGateway' );
    }

    /**
     * @return int
     */
    private function createTestToggle()
    {
        $toggle = new Toggle();
        $toggle->setName( "test toggle " . rand( 1, 9999 ) );

        return $this->toggleStorage->insertToggle( $toggle );
    }

    /**
     * @test
     */
    public function GivenGroupHasNoPolicyForToggle_WhenRequestingTogglePolicy_ResponseConfirmsNotSet()
    {
        $toggleId = $this->createTestToggle();
        $togglePolicyResponse = $this->groupPolicyGateway->getTogglePolicy( $toggleId, new GroupStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenGroupHasEnabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsEnabled()
    {
        $toggleId = $this->createTestToggle();
        $group = new GroupStub( 1 );
        $this->toggleStorage->setGroupPolicy( $toggleId, $group->getId(), true );

        $togglePolicyResponse = $this->groupPolicyGateway->getTogglePolicy( $toggleId, $group );

        $this->assertTrue( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenGroupHasDisabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsDisabled()
    {
        $toggleId = $this->createTestToggle();
        $group = new GroupStub( 1 );
        $this->toggleStorage->setGroupPolicy( $toggleId, $group->getId(), false );

        $togglePolicyResponse = $this->groupPolicyGateway->getTogglePolicy( $toggleId, $group );

        $this->assertTrue( $togglePolicyResponse->isDisabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
    }
}
