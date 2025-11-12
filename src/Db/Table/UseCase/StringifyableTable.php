<?php
namespace Clearbooks\Labs\Db\Table\UseCase;

abstract class StringifyableTable implements Table
{
    public function __toString(): string
    {
        return "`" . $this->getName() . "`";
    }
}
