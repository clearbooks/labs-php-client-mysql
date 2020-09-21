<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Toggle\Entity\UserStub;

class UserPolicyGatewayTest extends TogglePolicyGatewayTest
{
    const MAGIC_NON_EXISTENT_TOGGLE_ID = 999999;
    /**
     * @var UserPolicyGateway
     */
    private $userPolicyGateway;

    public function setUp(): void
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
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function GivenNoError_On_getPolicyOfToggleByName()
    {
        $userId = 1;
        $toggle = $this->createTestToggle();
        $this->toggleStorage->getPolicyOfToggleByName( $toggle->getName(), $userId, 'user' );
    }

    /**
     * @test
     */
    public function GivenNoError_On_getPolicyOfToggleByName_noToggle()
    {
        $this->assertNull( $this->toggleStorage->getPolicyOfToggleByName( 'Some random magic text', 1, 'user' ) );
    }

    /**
     * @test
     */
    public function GivenNoError_On_getPolicyOfToggleById_noToggle()
    {
        $this->assertNull( $this->toggleStorage->getPolicyOfToggleById( self::MAGIC_NON_EXISTENT_TOGGLE_ID, 1, 'user' ) );
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
    }
}
