<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class UserPolicy extends StringifyableTable
{
    public function getName(): string
    {
        return "user_policy";
    }
}
