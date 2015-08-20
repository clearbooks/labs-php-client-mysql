<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/08/15
 * Time: 14:46
 */

namespace Clearbooks\Labs\Mysql\Connection;


interface ConnectionProvider
{
    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection();
}