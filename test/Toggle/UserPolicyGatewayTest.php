<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Service\ToggleStorage;
use Clearbooks\Labs\LabsTest;
use Clearbooks\Labs\Toggle\Entity\UserStub;

class UserPolicyGatewayTest extends LabsTest
{
    /**
     * @var ToggleStorage
     */
    private $toggleStorage;

    /**
     * @var UserPolicyGateway
     */
    private $userPolicyGateway;

    public function setUp()
    {
        parent::setUp();
        $this->toggleStorage = Bootstrap::getInstance()->getDIContainer()
                                        ->get( 'Clearbooks\Labs\Db\Service\ToggleStorage' );

        $this->userPolicyGateway = Bootstrap::getInstance()->getDIContainer()
                                            ->get( 'Clearbooks\Labs\Toggle\UserPolicyGateway' );
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
    public function GivenUserHasNoPolicyForToggle_WhenRequestingTogglePolicy_ResponseConfirmsNotSet()
    {
        $toggleId = $this->createTestToggle();
        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggleId, new UserStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenUserHasEnabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsEnabled()
    {
        $toggleId = $this->createTestToggle();
        $user = new UserStub( 1 );
        $this->toggleStorage->setUserPolicy( $toggleId, $user->getId(), true );

        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggleId, $user );

        $this->assertTrue( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }

    /**
     * @test
     */
    public function GivenUserHasDisabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsDisabled()
    {
        $toggleId = $this->createTestToggle();
        $user = new UserStub( 1 );
        $this->toggleStorage->setUserPolicy( $toggleId, $user->getId(), false );

        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggleId, $user );

        $this->assertTrue( $togglePolicyResponse->isDisabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
    }

    /**
     * @test
     */
    public function GivenUserHasEnabledTheToggle_WhenChangingTogglePolicyToNotSet_ResponseConfirmsNotSet()
    {
        $toggleId = $this->createTestToggle();
        $user = new UserStub( 1 );
        $this->toggleStorage->setUserPolicy( $toggleId, $user->getId(), true );

        $this->toggleStorage->setUserPolicy( $toggleId, $user->getId(), null );
        $togglePolicyResponse = $this->userPolicyGateway->getTogglePolicy( $toggleId, new UserStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isDisabled() );
    }
}
