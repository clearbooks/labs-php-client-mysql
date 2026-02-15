<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class Toggle extends StringifyableTable
{
    public const string TYPE_GROUP = "group";
    public const string TYPE_SIMPLE = "simple";

    public function getName(): string
    {
        return "toggle";
    }
}
