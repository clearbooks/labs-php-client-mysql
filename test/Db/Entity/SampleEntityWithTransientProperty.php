<?php
namespace Clearbooks\Labs\Db\Entity;

class SampleEntityWithTransientProperty extends SampleEntityWithoutTransientProperty
{
    /**
     * @var string
     */
    protected $invalid_property;

    /**
     * @return string
     */
    public function getInvalidProperty()
    {
        return $this->invalid_property;
    }

    /**
     * @param string $invalid_property
     */
    public function setInvalidProperty( $invalid_property )
    {
        $this->invalid_property = $invalid_property;
    }

    /**
     * @return array
     */
    public function getTransientProperties()
    {
        return [ "invalid_property" ];
    }
}
