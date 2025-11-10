<?php
namespace Clearbooks\Labs\Db\Entity;

use DateTime;

class Release extends CamelCaseMapperEntity
{
    protected int $id;
    protected string $name;
    protected string $info = "";
    protected int $visibility;
    protected ?string $releaseDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId( int $id ): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName( string $name ): void
    {
        $this->name = $name;
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function setInfo( string $info ): void
    {
        $this->info = $info;
    }

    public function getVisibility(): bool
    {
        return !!$this->visibility;
    }

    public function setVisibility( bool $visibility ): void
    {
        $this->visibility = $visibility ? 1 : 0;
    }

    public function getReleaseDate(): ?DateTime
    {
        if ( empty( $this->releaseDate ) ) {
            return null;
        }

        return new DateTime( $this->releaseDate );
    }

    public function setReleaseDate( DateTime $releaseDate ): void
    {
        $this->releaseDate = $releaseDate->format( "Y-m-d" );
    }
}
