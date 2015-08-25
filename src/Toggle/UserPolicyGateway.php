<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Client\Toggle\Gateway\TogglePolicyGateway;
use Clearbooks\Labs\Toggle\UseCase\UserPolicyRetriever;

class UserPolicyGateway implements TogglePolicyGateway
{
    /**
     * @var UserPolicyRetriever
     */
    private $userPolicyRetriever;

    /**
     * @param UserPolicyRetriever $userPolicyRetriever
     */
    public function __construct( UserPolicyRetriever $userPolicyRetriever )
    {
        $this->userPolicyRetriever = $userPolicyRetriever;
    }

    /**
     * @param string   $toggleId
     * @param Identity $idHolder
     * @return TogglePolicyResponse
     */
    public function getTogglePolicy( $toggleId, Identity $idHolder )
    {
        $togglePolicyActive = $this->userPolicyRetriever->getUserPolicyOfToggle( $toggleId, $idHolder->getId() );
        return new TogglePolicyResponse( $togglePolicyActive );
    }
}
