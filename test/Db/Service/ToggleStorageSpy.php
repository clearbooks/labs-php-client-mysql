<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;

class ToggleStorageSpy implements ToggleStorageOperations
{
    /**
     * @var int
     */
    private $getGroupPolicyOfToggleCallCounter = 0;

    /**
     * @var int
     */
    private $getToggleByIdCallCounter = 0;

    /**
     * @var int
     */
    private $getToggleByNameCallCounter = 0;

    /**
     * @var int
     */
    private $getUserPolicyOfToggleCallCounter = 0;

    /**
     * @param string $toggleName
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleName, $groupId )
    {
        ++$this->getGroupPolicyOfToggleCallCounter;
        return false;
    }

    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId )
    {
        ++$this->getToggleByIdCallCounter;
        return new Toggle();
    }

    /**
     * @param string $toggleName
     * @return Toggle|null
     */
    public function getToggleByName( $toggleName )
    {
        ++$this->getToggleByNameCallCounter;
        return new Toggle();
    }

    /**
     * @param string $toggleName
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleName, $userId )
    {
        ++$this->getUserPolicyOfToggleCallCounter;
        return false;
    }

    /**
     * @return int
     */
    public function getGetGroupPolicyOfToggleCallCounter()
    {
        return $this->getGroupPolicyOfToggleCallCounter;
    }

    /**
     * @return int
     */
    public function getGetToggleByIdCallCounter()
    {
        return $this->getToggleByIdCallCounter;
    }

    /**
     * @return int
     */
    public function getGetToggleByNameCallCounter()
    {
        return $this->getToggleByNameCallCounter;
    }

    /**
     * @return int
     */
    public function getGetUserPolicyOfToggleCallCounter()
    {
        return $this->getUserPolicyOfToggleCallCounter;
    }
}
