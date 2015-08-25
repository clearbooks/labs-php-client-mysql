<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class UserPolicy extends StringifyableTable
{
    /**
     * @return string
     */
    public function getName()
    {
        return "user_policy";
    }
}
