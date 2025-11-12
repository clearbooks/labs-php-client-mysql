<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Client\Toggle\Gateway\UserTogglePolicyGateway;
use Clearbooks\Labs\Toggle\UseCase\UserPolicyRetriever;

class UserPolicyGateway implements UserTogglePolicyGateway
{
    private UserPolicyRetriever $userPolicyRetriever;

    public function __construct( UserPolicyRetriever $userPolicyRetriever )
    {
        $this->userPolicyRetriever = $userPolicyRetriever;
    }

    /**
     * @param string   $toggleName
     * @param Identity $idHolder
     * @return TogglePolicyResponse
     */
    public function getTogglePolicy( $toggleName, Identity $idHolder ): TogglePolicyResponse
    {
        $togglePolicyActive = $this->userPolicyRetriever->getUserPolicyOfToggle( $toggleName, $idHolder->getId() );
        return new TogglePolicyResponse( $togglePolicyActive );
    }
}
