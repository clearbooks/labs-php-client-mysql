<?php
namespace Clearbooks\Labs\Db\Entity;

class SampleEntityWithoutTransientProperty extends CamelCaseMapperEntity
{
    protected string $single;
    protected string $multipleWords;
    protected string $moreThanTwoWords;

    public function getSingle(): string
    {
        return $this->single;
    }

    public function setSingle( string $single ): void
    {
        $this->single = $single;
    }

    public function getMultipleWords(): string
    {
        return $this->multipleWords;
    }

    public function setMultipleWords( string $multipleWords ): void
    {
        $this->multipleWords = $multipleWords;
    }

    public function getMoreThanTwoWords(): string
    {
        return $this->moreThanTwoWords;
    }

    public function setMoreThanTwoWords( string $moreThanTwoWords ): void
    {
        $this->moreThanTwoWords = $moreThanTwoWords;
    }
}
