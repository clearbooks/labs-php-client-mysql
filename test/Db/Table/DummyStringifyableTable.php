<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class DummyStringifyableTable extends StringifyableTable
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return "dummy";
    }
}
