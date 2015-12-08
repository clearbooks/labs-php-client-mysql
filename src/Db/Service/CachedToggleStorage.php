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
        if ( !isset( $this->toggleIdToToggleMap[$toggleId] ) ) {
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
        if ( !isset( $this->toggleNameToToggleMap[$toggleName] ) ) {
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

        if ( !isset( $this->toggleGroupPolicyMap[$toggleName][$groupId] ) ) {
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

        if ( !isset( $this->toggleUserPolicyMap[$toggleName][$userId] ) ) {
            $this->toggleUserPolicyMap[$toggleName][$userId] = $this->toggleStorage->getUserPolicyOfToggle( $toggleName, $userId );
        }

        return $this->toggleUserPolicyMap[$toggleName][$userId];
    }
}
