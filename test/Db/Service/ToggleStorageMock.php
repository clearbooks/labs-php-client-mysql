<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;

class ToggleStorageMock implements ToggleStorageOperations
{
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
    private $toggleUserPolicyMap = [ ];

    /**
     * @var array
     */
    private $toggleGroupPolicyMap = [ ];

    /**
     * @var array
     */
    private $toggleSegmentPolicyMap = [ ];

    /**
     * @param array $toggleIdToToggleMap
     */
    public function setToggleIdToToggleMap( array $toggleIdToToggleMap )
    {
        $this->toggleIdToToggleMap = $toggleIdToToggleMap;
    }

    /**
     * @param array $toggleNameToToggleMap
     */
    public function setToggleNameToToggleMap( array $toggleNameToToggleMap )
    {
        $this->toggleNameToToggleMap = $toggleNameToToggleMap;
    }

    /**
     * @param array $toggleUserPolicyMap
     */
    public function setToggleUserPolicyMap( array $toggleUserPolicyMap )
    {
        $this->toggleUserPolicyMap = $toggleUserPolicyMap;
    }

    /**
     * @param array $toggleGroupPolicyMap
     */
    public function setToggleGroupPolicyMap( array $toggleGroupPolicyMap )
    {
        $this->toggleGroupPolicyMap = $toggleGroupPolicyMap;
    }

    /**
     * @param array $toggleSegmentPolicyMap
     */
    public function setToggleSegmentPolicyMap( array $toggleSegmentPolicyMap )
    {
        $this->toggleSegmentPolicyMap = $toggleSegmentPolicyMap;
    }

    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId )
    {
        return isset( $this->toggleIdToToggleMap[$toggleId] ) ? $this->toggleIdToToggleMap[$toggleId] : null;
    }

    /**
     * @param string $toggleName
     * @return Toggle|null
     */
    public function getToggleByName( $toggleName )
    {
        return isset( $this->toggleNameToToggleMap[$toggleName] ) ? $this->toggleNameToToggleMap[$toggleName] : null;
    }

    /**
     * @param string $toggleName
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleName, $userId )
    {
        return isset( $this->toggleUserPolicyMap[$toggleName][$userId] ) ? $this->toggleUserPolicyMap[$toggleName][$userId] : null;
    }

    /**
     * @param string $toggleName
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleName, $groupId )
    {
        return isset( $this->toggleGroupPolicyMap[$toggleName][$groupId] ) ? $this->toggleGroupPolicyMap[$toggleName][$groupId] : null;
    }

    /**
     * @param string $toggleName
     * @param string $segmentId
     * @return bool|null
     */
    public function getSegmentPolicyOfToggle( $toggleName, $segmentId )
    {
        return isset( $this->toggleSegmentPolicyMap[$toggleName][$segmentId] ) ? $this->toggleSegmentPolicyMap[$toggleName][$segmentId] : null;
    }
}
