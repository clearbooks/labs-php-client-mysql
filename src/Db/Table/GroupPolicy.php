<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class GroupPolicy extends StringifyableTable
{
    /**
     * @return string
     */
    public function getName()
    {
        return "group_policy";
    }
}
