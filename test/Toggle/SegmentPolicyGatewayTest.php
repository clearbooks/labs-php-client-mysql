<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Toggle\Entity\SegmentStub;

class SegmentPolicyGatewayTest extends TogglePolicyGatewayTest
{
    /**
     * @var SegmentPolicyGateway
     */
    private $segmentPolicyGateway;

    public function setUp(): void
    {
        parent::setUp();
        $this->segmentPolicyGateway = Bootstrap::getInstance()->getDIContainer()
                                             ->get( SegmentPolicyGateway::class );
    }

    /**
     * @test
     */
    public function GivenSegmentHasNoPolicyForToggle_WhenRequestingTogglePolicy_ResponseConfirmsNotSet()
    {
        $toggle = $this->createTestToggle();
        $togglePolicyResponse = $this->segmentPolicyGateway->getTogglePolicy( $toggle->getName(), new SegmentStub( 1 ) );

        $this->assertTrue( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
    }

    /**
     * @test
     */
    public function GivenSegmentHasEnabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsEnabled()
    {
        $toggle = $this->createTestToggle();
        $segment = new SegmentStub( 1 );
        $this->toggleStorage->setSegmentPolicy( $toggle->getId(), $segment->getId(), true );

        $togglePolicyResponse = $this->segmentPolicyGateway->getTogglePolicy( $toggle->getName(), $segment );

        $this->assertTrue( $togglePolicyResponse->isEnabled() );
        $this->assertFalse( $togglePolicyResponse->isNotSet() );
    }

    /**
     * @test
     */
    public function GivenSegmentHasDisabledTheToggle_WhenRequestingTogglePolicy_ResponseConfirmsDisabled()
    {
        $toggle = $this->createTestToggle();
        $segment = new SegmentStub( 1 );
        $this->toggleStorage->setSegmentPolicy( $toggle->getId(), $segment->getId(), false );

        $togglePolicyResponse = $this->segmentPolicyGateway->getTogglePolicy( $toggle->getName(), $segment );

        $this->assertFalse( $togglePolicyResponse->isNotSet() );
        $this->assertFalse( $togglePolicyResponse->isEnabled() );
    }
}
