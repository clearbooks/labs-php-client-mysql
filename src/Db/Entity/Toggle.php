<?php
namespace Clearbooks\Labs\Db\Entity;

class Toggle extends CamelCaseMapperEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $visible;

    /**
     * @var int
     */
    protected $releaseId;

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType( $type )
    {
        $this->type = $type;
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        return !!$this->visible;
    }

    /**
     * @param boolean $visible
     */
    public function setVisible( $visible )
    {
        $this->visible = $visible ? 1 : 0;
    }

    /**
     * @return int
     */
    public function getReleaseId()
    {
        return $this->releaseId;
    }

    /**
     * @param int $releaseId
     */
    public function setReleaseId( $releaseId )
    {
        $this->releaseId = $releaseId;
    }
}
