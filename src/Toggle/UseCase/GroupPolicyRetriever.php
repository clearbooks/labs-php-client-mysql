<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface GroupPolicyRetriever
{
    /**
     * @param int $toggleId
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleId, $groupId );
}
