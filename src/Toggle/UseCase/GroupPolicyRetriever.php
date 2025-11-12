<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface GroupPolicyRetriever
{
    public function getGroupPolicyOfToggle( string $toggleName, string $groupId ): ?bool;
}
