<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Client\Toggle\Gateway\GroupTogglePolicyGateway;
use Clearbooks\Labs\Toggle\UseCase\GroupPolicyRetriever;

class GroupPolicyGateway implements GroupTogglePolicyGateway
{
    private GroupPolicyRetriever $groupPolicyRetriever;

    public function __construct( GroupPolicyRetriever $groupPolicyRetriever )
    {
        $this->groupPolicyRetriever = $groupPolicyRetriever;
    }

    /**
     * @param string   $toggleName
     * @param Identity $idHolder
     * @return TogglePolicyResponse
     */
    public function getTogglePolicy( $toggleName, Identity $idHolder ): TogglePolicyResponse
    {
        $togglePolicyActive = $this->groupPolicyRetriever->getGroupPolicyOfToggle( $toggleName, $idHolder->getId() );
        return new TogglePolicyResponse( $togglePolicyActive );
    }
}
