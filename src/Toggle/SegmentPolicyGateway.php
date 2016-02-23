<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Client\Toggle\Gateway\SegmentTogglePolicyGateway;
use Clearbooks\Labs\Toggle\UseCase\SegmentPolicyRetriever;

class SegmentPolicyGateway implements SegmentTogglePolicyGateway
{
    /**
     * @var SegmentPolicyRetriever
     */
    private $segmentPolicyRetriever;

    /**
     * @param SegmentPolicyRetriever $segmentPolicyRetriever
     */
    public function __construct( SegmentPolicyRetriever $segmentPolicyRetriever )
    {
        $this->segmentPolicyRetriever = $segmentPolicyRetriever;
    }

    /**
     * @param string   $toggleName
     * @param Identity $idHolder
     * @return TogglePolicyResponse
     */
    public function getTogglePolicy( $toggleName, Identity $idHolder )
    {
        $togglePolicyActive = $this->segmentPolicyRetriever->getSegmentPolicyOfToggle( $toggleName, $idHolder->getId() );
        return new TogglePolicyResponse( $togglePolicyActive );
    }
}
