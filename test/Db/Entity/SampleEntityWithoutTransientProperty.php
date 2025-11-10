<?php
namespace Clearbooks\Labs\Db\Entity;

class SampleEntityWithoutTransientProperty extends CamelCaseMapperEntity
{
    /**
     * @var string
     */
    protected $single;

    /**
     * @var string
     */
    protected $multipleWords;

    /**
     * @var string
     */
    protected $moreThanTwoWords;

    /**
     * @return string
     */
    public function getSingle()
    {
        return $this->single;
    }

    /**
     * @param string $single
     */
    public function setSingle( $single )
    {
        $this->single = $single;
    }

    /**
     * @return string
     */
    public function getMultipleWords()
    {
        return $this->multipleWords;
    }

    /**
     * @param string $multipleWords
     */
    public function setMultipleWords( $multipleWords )
    {
        $this->multipleWords = $multipleWords;
    }

    /**
     * @return string
     */
    public function getMoreThanTwoWords()
    {
        return $this->moreThanTwoWords;
    }

    /**
     * @param string $moreThanTwoWords
     */
    public function setMoreThanTwoWords( $moreThanTwoWords )
    {
        $this->moreThanTwoWords = $moreThanTwoWords;
    }
}
