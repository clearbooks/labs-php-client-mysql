<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class SegmentPolicy extends StringifyableTable
{
    public function getName(): string
    {
        return "segment_policy";
    }
}
