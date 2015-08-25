<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Client\Toggle\Gateway\TogglePolicyGateway;
use Clearbooks\Labs\Toggle\UseCase\GroupPolicyRetriever;

class GroupPolicyGateway implements TogglePolicyGateway
{
    /**
     * @var GroupPolicyRetriever
     */
    private $groupPolicyRetriever;

    /**
     * @param GroupPolicyRetriever $groupPolicyRetriever
     */
    public function __construct( GroupPolicyRetriever $groupPolicyRetriever )
    {
        $this->groupPolicyRetriever = $groupPolicyRetriever;
    }

    /**
     * @param string   $toggleId
     * @param Identity $idHolder
     * @return TogglePolicyResponse
     */
    public function getTogglePolicy( $toggleId, Identity $idHolder )
    {
        $togglePolicyActive = $this->groupPolicyRetriever->getGroupPolicyOfToggle( $toggleId, $idHolder->getId() );
        return new TogglePolicyResponse( $togglePolicyActive );
    }
}
