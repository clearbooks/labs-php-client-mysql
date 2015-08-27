<?php
namespace Clearbooks\Labs\Db\Table\UseCase;

abstract class StringifyableTable implements Table
{
    public function __toString()
    {
        return $this->getName();
    }
}
