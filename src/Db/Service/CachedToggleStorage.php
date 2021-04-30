<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;

class CachedToggleStorage implements ToggleStorageOperations
{
    /**
     * @var ToggleStorageOperations
     */
    private $toggleStorage;

    /**
     * @var array
     */
    private $toggleIdToToggleMap = [ ];

    /**
     * @var array
     */
    private $toggleNameToToggleMap = [ ];

    /**
     * @var array
     */
    private $toggleGroupPolicyMap = [ ];

    /**
     * @var array
     */
    private $toggleUserPolicyMap = [ ];

    /**
     * @var array
     */
    private $toggleSegmentPolicyMap = [ ];

    /**
     * @param ToggleStorageOperations $toggleStorage
     */
    public function __construct( ToggleStorageOperations $toggleStorage )
    {
        $this->toggleStorage = $toggleStorage;
    }

    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId )
    {
        if ( !array_key_exists( $toggleId, $this->toggleIdToToggleMap ) ) {
            $this->toggleIdToToggleMap[$toggleId] = $this->toggleStorage->getToggleById( $toggleId );
        }

        return $this->toggleIdToToggleMap[$toggleId];
    }

    /**
     * @param string $toggleName
     * @return Toggle|null
     */
    public function getToggleByName( $toggleName )
    {
        if ( !array_key_exists( $toggleName, $this->toggleNameToToggleMap ) ) {
            $this->toggleNameToToggleMap[$toggleName] = $this->toggleStorage->getToggleByName( $toggleName );
        }

        return $this->toggleNameToToggleMap[$toggleName];
    }

    /**
     * @param string $toggleName
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleName, $groupId )
    {
        if ( !isset( $this->toggleGroupPolicyMap[$toggleName] ) ) {
            $this->toggleGroupPolicyMap[$toggleName] = [ ];
        }

        if ( !array_key_exists( $groupId, $this->toggleGroupPolicyMap[$toggleName] ) ) {
            $this->toggleGroupPolicyMap[$toggleName][$groupId] = $this->toggleStorage->getGroupPolicyOfToggle( $toggleName, $groupId );
        }

        return $this->toggleGroupPolicyMap[$toggleName][$groupId];
    }

    /**
     * @param string $toggleName
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleName, $userId )
    {
        if ( !isset( $this->toggleUserPolicyMap[$toggleName] ) ) {
            $this->toggleUserPolicyMap[$toggleName] = [ ];
        }

        if ( !array_key_exists( $userId, $this->toggleUserPolicyMap[$toggleName] ) ) {
            $this->toggleUserPolicyMap[$toggleName][$userId] = $this->toggleStorage->getUserPolicyOfToggle( $toggleName, $userId );
        }

        return $this->toggleUserPolicyMap[$toggleName][$userId];
    }

    /**
     * @param string $toggleName
     * @param string $segmentId
     * @return bool|null
     */
    public function getSegmentPolicyOfToggle( $toggleName, $segmentId )
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
