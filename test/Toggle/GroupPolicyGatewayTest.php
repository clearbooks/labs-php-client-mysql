<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Toggle\Entity\GroupStub;

class GroupPolicyGatewayTest extends TogglePolicyGatewayTest
{
    /**
     * @var GroupPolicyGateway
     */
    private $groupPolicyGateway;

    public function setUp()
    {
        parent::setUp();
        $this->groupPolicyGateway = Bootstrap::getInstance()->getDIContainer()
                                             ->get( GroupPolicyGateway::class );
    }

    /**
     * @test
     */
    public function GivenGroupHasNoPolicyForToggle_WhenRequestingTogglePolicy_ResponseConfirmsNotSet()
    {
        $toggle = $this->createTestToggle();
        $togglePolicyResponse = $this->groupPolicyGateway->getTogglePolicy( $toggle->getName(), new GroupStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenGroupHasEnabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsEnabled()
    {
        $toggle = $this->createTestToggle();
        $group = new GroupStub( 1 );
        $this->toggleStorage->setGroupPolicy( $toggle->getId(), $group->getId(), true );

        $togglePolicyResponse = $this->groupPolicyGateway->getTogglePolicy( $toggle->getName(), $group );

        $this->assertTrue( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenGroupHasDisabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsDisabled()
    {
        $toggle = $this->createTestToggle();
        $group = new GroupStub( 1 );
        $this->toggleStorage->setGroupPolicy( $toggle->getId(), $group->getId(), false );

        $togglePolicyResponse = $this->groupPolicyGateway->getTogglePolicy( $toggle->getName(), $group );

        $this->assertTrue( $togglePolicyResponse->isDisabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
    }
}
