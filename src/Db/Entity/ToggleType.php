<?php
namespace Clearbooks\Labs\Db\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="toggle_type")
 */
class ToggleType
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, name="type_name")
     */
    private $typeName;

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
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * @param string $typeName
     */
    public function setTypeName( $typeName )
    {
        $this->typeName = $typeName;
    }
}
