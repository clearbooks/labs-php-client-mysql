<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface UserPolicyRetriever
{
    /**
     * @param int $toggleId
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleId, $userId );
}
