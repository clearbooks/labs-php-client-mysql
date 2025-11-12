<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;

class CachedToggleStorage implements ToggleStorageOperations
{
    private ToggleStorageOperations $toggleStorage;
    private array $toggleIdToToggleMap = [ ];
    private array $toggleNameToToggleMap = [ ];
    private array $toggleGroupPolicyMap = [ ];
    private array $toggleUserPolicyMap = [ ];
    private array $toggleSegmentPolicyMap = [ ];

    public function __construct( ToggleStorageOperations $toggleStorage )
    {
        $this->toggleStorage = $toggleStorage;
    }

    public function getToggleById( int $toggleId ): ?Toggle
    {
        if ( !array_key_exists( $toggleId, $this->toggleIdToToggleMap ) ) {
            $this->toggleIdToToggleMap[$toggleId] = $this->toggleStorage->getToggleById( $toggleId );
        }

        return $this->toggleIdToToggleMap[$toggleId];
    }

    public function getToggleByName( string $toggleName ): ?Toggle
    {
        if ( !array_key_exists( $toggleName, $this->toggleNameToToggleMap ) ) {
            $this->toggleNameToToggleMap[$toggleName] = $this->toggleStorage->getToggleByName( $toggleName );
        }

        return $this->toggleNameToToggleMap[$toggleName];
    }

    public function getGroupPolicyOfToggle( string $toggleName, string $groupId ): ?bool
    {
        if ( !isset( $this->toggleGroupPolicyMap[$toggleName] ) ) {
            $this->toggleGroupPolicyMap[$toggleName] = [ ];
        }

        if ( !array_key_exists( $groupId, $this->toggleGroupPolicyMap[$toggleName] ) ) {
            $this->toggleGroupPolicyMap[$toggleName][$groupId] = $this->toggleStorage->getGroupPolicyOfToggle( $toggleName, $groupId );
        }

        return $this->toggleGroupPolicyMap[$toggleName][$groupId];
    }

    public function getUserPolicyOfToggle( string $toggleName, string $userId ): ?bool
    {
        if ( !isset( $this->toggleUserPolicyMap[$toggleName] ) ) {
            $this->toggleUserPolicyMap[$toggleName] = [ ];
        }

        if ( !array_key_exists( $userId, $this->toggleUserPolicyMap[$toggleName] ) ) {
            $this->toggleUserPolicyMap[$toggleName][$userId] = $this->toggleStorage->getUserPolicyOfToggle( $toggleName, $userId );
        }

        return $this->toggleUserPolicyMap[$toggleName][$userId];
    }

    public function getSegmentPolicyOfToggle( string $toggleName, string $segmentId ): ?bool
    {
        if ( !isset( $this->toggleSegmentPolicyMap[$toggleName] ) ) {
            $this->toggleSegmentPolicyMap[$toggleName] = [ ];
        }

        if ( !array_key_exists( $segmentId, $this->toggleSegmentPolicyMap[$toggleName] ) ) {
            $this->toggleSegmentPolicyMap[$toggleName][$segmentId] = $this->toggleStorage->getSegmentPolicyOfToggle( $toggleName, $segmentId );
        }

        return $this->toggleSegmentPolicyMap[$toggleName][$segmentId];
    }
}
