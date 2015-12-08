<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface UserPolicyRetriever
{
    /**
     * @param string $toggleName
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleName, $userId );
}
