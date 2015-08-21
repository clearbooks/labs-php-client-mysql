<?php
namespace Clearbooks\Labs\Db\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_activated_toggle")
 */
class UserActivatedToggle
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="toggle_id")
     */
    private $toggleId;

    /**
     * @ORM\Column(type="boolean", name="is_active")
     */
    private $isActive;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId( $userId )
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getToggleId()
    {
        return $this->toggleId;
    }

    /**
     * @param int $toggleId
     */
    public function setToggleId( $toggleId )
    {
        $this->toggleId = $toggleId;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive( $isActive )
    {
        $this->isActive = $isActive;
    }
}
