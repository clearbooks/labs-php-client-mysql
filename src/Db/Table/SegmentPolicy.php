<?php
namespace Clearbooks\Labs\Db\Table;

use Clearbooks\Labs\Db\Table\UseCase\StringifyableTable;

class SegmentPolicy extends StringifyableTable
{
    /**
     * @return string
     */
    public function getName()
    {
        return "segment_policy";
    }
}
