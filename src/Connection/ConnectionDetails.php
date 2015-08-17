<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/08/15
 * Time: 16:01
 */
namespace Clearbooks\LabsMysql\Connection;

interface ConnectionDetails
{
    /**
     * @return array
     */
    public function toArray();
}