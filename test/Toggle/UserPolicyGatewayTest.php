<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Toggle\Entity\UserStub;

class UserPolicyGatewayTest extends TogglePolicyGatewayTest
{
    /**
     * @var UserPolicyGateway
     */
    private $userPolicyGateway;

    public function setUp()
    {
        parent::setUp();
        $this->userPolicyGateway = Bootstrap::getInstance()->getDIContainer()
                                            ->get( UserPolicyGateway::class );
    }

    /**
     * @test
     */
    public function GivenUserHasNoPolicyForToggle_WhenRequestingTogglePolicy_ResponseConfirmsNotSet()
    {
        $toggle = $this->createTestToggle();
        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggle->getName(), new UserStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenUserHasEnabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsEnabled()
    {
        $toggle = $this->createTestToggle();
        $user = new UserStub( 1 );
        $this->toggleStorage->setUserPolicy( $toggle->getId(), $user->getId(), true );

        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggle->getName(), $user );

        $this->assertTrue( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenUserHasDisabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsDisabled()
    {
        $toggle = $this->createTestToggle();
        $user = new UserStub( 1 );
        $this->toggleStorage->setUserPolicy( $toggle->getId(), $user->getId(), false );

        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggle->getName(), $user );

        $this->assertTrue( $togglePolicyResponse->isDisabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
    }

    /**
     * @test
     */
    public function GivenUserHasEnabledTheToggle_WhenChangingTogglePolicyToNotSet_ResponseConfirmsNotSet()
    {
        $toggle = $this->createTestToggle();
        $user = new UserStub( 1 );
        $this->toggleStorage->setUserPolicy( $toggle->getId(), $user->getId(), true );

        $this->toggleStorage->setUserPolicy( $toggle->getId(), $user->getId(), null );
        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggle->getName(), new UserStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }
}
