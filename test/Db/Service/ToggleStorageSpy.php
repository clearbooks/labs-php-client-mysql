<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;

class ToggleStorageSpy implements ToggleStorageOperations
{
    private int $getToggleByIdCallCounter = 0;
    private int $getToggleByNameCallCounter = 0;
    private int $getUserPolicyOfToggleCallCounter = 0;
    private int $getGroupPolicyOfToggleCallCounter = 0;
    private int $getSegmentPolicyOfToggleCallCounter = 0;

    public function getToggleById( int $toggleId ): ?Toggle
    {
        ++$this->getToggleByIdCallCounter;
        return new Toggle();
    }

    public function getToggleByName( string $toggleName ): ?Toggle
    {
        ++$this->getToggleByNameCallCounter;
        return new Toggle();
    }

    public function getUserPolicyOfToggle( string $toggleName, string $userId ): ?bool
    {
        ++$this->getUserPolicyOfToggleCallCounter;
        return false;
    }

    public function getGroupPolicyOfToggle( string $toggleName, string $groupId ): ?bool
    {
        ++$this->getGroupPolicyOfToggleCallCounter;
        return false;
    }

    public function getSegmentPolicyOfToggle( string $toggleName, string $segmentId ): ?bool
    {
        ++$this->getSegmentPolicyOfToggleCallCounter;
        return false;
    }

    public function getGetToggleByIdCallCounter(): int
    {
        return $this->getToggleByIdCallCounter;
    }

    public function getGetToggleByNameCallCounter(): int
    {
        return $this->getToggleByNameCallCounter;
    }

    public function getGetUserPolicyOfToggleCallCounter(): int
    {
        return $this->getUserPolicyOfToggleCallCounter;
    }

    public function getGetGroupPolicyOfToggleCallCounter(): int
    {
        return $this->getGroupPolicyOfToggleCallCounter;
    }

    public function getGetSegmentPolicyOfToggleCallCounter(): int
    {
        return $this->getSegmentPolicyOfToggleCallCounter;
    }
}
