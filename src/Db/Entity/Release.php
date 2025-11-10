<?php
namespace Clearbooks\Labs\Db\Entity;

class Release extends CamelCaseMapperEntity
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
    protected $info = "";

    /**
     * @var int
     */
    protected $visibility;

    /**
     * @Nullable
     * @var string
     */
    protected $releaseDate;

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
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $info
     */
    public function setInfo( $info )
    {
        $this->info = $info;
    }

    /**
     * @return bool
     */
    public function getVisibility()
    {
        return !!$this->visibility;
    }

    /**
     * @param bool $visibility
     */
    public function setVisibility( $visibility )
    {
        $this->visibility = $visibility ? 1 : 0;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        if ( empty( $this->releaseDate ) ) {
            return null;
        }

        return new \DateTime( $this->releaseDate );
    }

    /**
     * @param \DateTime $releaseDate
     */
    public function setReleaseDate( \DateTime $releaseDate )
    {
        $this->releaseDate = $releaseDate->format( "Y-m-d" );
    }
}
