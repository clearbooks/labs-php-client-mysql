<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class Subscribers extends StringifyableTable
{
    /**
     * @return string
     */
    public function getName()
    {
        return "subscribers";
    }
}
