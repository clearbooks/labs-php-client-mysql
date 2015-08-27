<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class Toggle extends StringifyableTable
{
    const TYPE_GROUP = "group";
    const TYPE_SIMPLE = "simple";

    /**
     * @return string
     */
    public function getName()
    {
        return "toggle";
    }
}
