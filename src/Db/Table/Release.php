<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class Release extends StringifyableTable
{
    public function getName(): string
    {
        return "release";
    }
}
