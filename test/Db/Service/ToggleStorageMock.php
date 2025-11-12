<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;

class ToggleStorageMock implements ToggleStorageOperations
{
    private array $callHistory = [];
    private array $toggleIdToToggleMap = [ ];
    private array $toggleNameToToggleMap = [ ];
    private array $toggleUserPolicyMap = [ ];
    private array $toggleGroupPolicyMap = [ ];
    private array $toggleSegmentPolicyMap = [ ];

    public function setToggleIdToToggleMap( array $toggleIdToToggleMap ): void
    {
        $this->toggleIdToToggleMap = $toggleIdToToggleMap;
    }

    public function setToggleNameToToggleMap( array $toggleNameToToggleMap )
    {
        $this->toggleNameToToggleMap = $toggleNameToToggleMap;
    }

    public function setToggleUserPolicyMap( array $toggleUserPolicyMap )
    {
        $this->toggleUserPolicyMap = $toggleUserPolicyMap;
    }

    public function setToggleGroupPolicyMap( array $toggleGroupPolicyMap )
    {
        $this->toggleGroupPolicyMap = $toggleGroupPolicyMap;
    }

    public function setToggleSegmentPolicyMap( array $toggleSegmentPolicyMap )
    {
        $this->toggleSegmentPolicyMap = $toggleSegmentPolicyMap;
    }

    public function getToggleById( int $toggleId ): ?Toggle
    {
        $this->callHistory[] = [ "getToggleById", $toggleId ];
        return isset( $this->toggleIdToToggleMap[$toggleId] ) ? $this->toggleIdToToggleMap[$toggleId] : null;
    }

    public function getToggleByName( string $toggleName ): ?Toggle
    {
        $this->callHistory[] = [ "getToggleByName", $toggleName ];
        return isset( $this->toggleNameToToggleMap[$toggleName] ) ? $this->toggleNameToToggleMap[$toggleName] : null;
    }

    public function getUserPolicyOfToggle( string $toggleName, string $userId ): ?bool
    {
        $this->callHistory[] = [ "getUserPolicyOfToggle", $toggleName, $userId ];
        return isset( $this->toggleUserPolicyMap[$toggleName][$userId] ) ? $this->toggleUserPolicyMap[$toggleName][$userId] : null;
    }

    public function getGroupPolicyOfToggle( string $toggleName, string $groupId ): ?bool
    {
        $this->callHistory[] = [ "getGroupPolicyOfToggle", $toggleName, $groupId ];
        return isset( $this->toggleGroupPolicyMap[$toggleName][$groupId] ) ? $this->toggleGroupPolicyMap[$toggleName][$groupId] : null;
    }

    public function getSegmentPolicyOfToggle( string $toggleName, string $segmentId ): ?bool
    {
        $this->callHistory[] = [ "getSegmentPolicyOfToggle", $toggleName, $segmentId ];
        return isset( $this->toggleSegmentPolicyMap[$toggleName][$segmentId] ) ? $this->toggleSegmentPolicyMap[$toggleName][$segmentId] : null;
    }

    public function getCallHistory(): array
    {
        return $this->callHistory;
    }
}
