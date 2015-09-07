<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Client\Toggle\Gateway\GroupTogglePolicyGateway;
use Clearbooks\Labs\Toggle\UseCase\GroupPolicyRetriever;

class GroupPolicyGateway implements GroupTogglePolicyGateway
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
     * @param string   $toggleName
     * @param Identity $idHolder
     * @return TogglePolicyResponse
     */
    public function getTogglePolicy( $toggleName, Identity $idHolder )
    {
        $togglePolicyActive = $this->groupPolicyRetriever->getGroupPolicyOfToggle( $toggleName, $idHolder->getId() );
        return new TogglePolicyResponse( $togglePolicyActive );
    }
}
