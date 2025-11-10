<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface UserPolicyRetriever
{
    public function getUserPolicyOfToggle( string $toggleName, string $userId ): ?bool;
}
