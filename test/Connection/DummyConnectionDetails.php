<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/08/15
 * Time: 16:28
 */

namespace Clearbooks\Labs\Mysql\Connection;


class DummyConnectionDetails implements ConnectionDetails
{

    /**
     * @return array
     */
    public function toArray()
    {
        return [ null ];
    }
}