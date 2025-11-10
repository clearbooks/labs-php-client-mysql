<?php
namespace Clearbooks\Labs\Db\Entity;

class SampleEntityWithTransientProperty extends SampleEntityWithoutTransientProperty
{
    /**
     * @Transient
     */
    protected string $invalid_property;

    public function getInvalidProperty(): string
    {
        return $this->invalid_property;
    }

    public function setInvalidProperty( string $invalid_property ): void
    {
        $this->invalid_property = $invalid_property;
    }
}
