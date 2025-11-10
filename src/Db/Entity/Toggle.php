<?php
namespace Clearbooks\Labs\Db\Entity;

class Toggle extends CamelCaseMapperEntity
{
    protected int $id;
    protected string $name;
    protected string $type;
    protected int $visible;
    protected ?int $releaseId;

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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType( string $type )
    {
        $this->type = $type;
    }

    public function isVisible(): bool
    {
        return !!$this->visible;
    }

    public function setVisible( bool $visible ): void
    {
        $this->visible = $visible ? 1 : 0;
    }

    public function getReleaseId(): int
    {
        return $this->releaseId;
    }

    public function setReleaseId( int $releaseId ): void
    {
        $this->releaseId = $releaseId;
    }
}
