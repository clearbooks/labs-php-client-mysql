<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface GroupPolicyRetriever
{
    /**
     * @param string $toggleName
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleName, $groupId );
}
