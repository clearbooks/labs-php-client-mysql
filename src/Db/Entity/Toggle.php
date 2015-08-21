<?php
namespace Clearbooks\Labs\Db\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="toggle")
 */
class Toggle
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Release")
     * @ORM\JoinColumn(name="release_id")
     */
    private $release;

    /**
     * @ORM\ManyToOne(targetEntity="ToggleType")
     * @ORM\JoinColumn(name="toggle_type")
     */
    private $toggleType;

    /**
     * @ORM\Column(type="boolean", name="is_active")
     */
    private $isActive;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId( $id )
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return Release
     */
    public function getRelease()
    {
        return $this->release;
    }

    /**
     * @param Release $release
     */
    public function setRelease( $release )
    {
        $this->release = $release;
    }

    /**
     * @return ToggleType
     */
    public function getToggleType()
    {
        return $this->toggleType;
    }

    /**
     * @param ToggleType $toggleType
     */
    public function setToggleType( $toggleType )
    {
        $this->toggleType = $toggleType;
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
