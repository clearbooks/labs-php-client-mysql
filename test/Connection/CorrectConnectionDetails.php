<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 17/08/15
 * Time: 09:44
 */

namespace Clearbooks\Labs\Mysql\Connection;


class CorrectConnectionDetails implements ConnectionDetails
{
    private $dbname = 'labs';
    private $user = 'root';
    private $password = '';
    private $host = 'localhost';
    private $driver = 'pdo_mysql';

    public function toArray()
    {
        return array(
            'dbname' => $this->dbname,
            'user' => $this->user,
            'password' => $this->password,
            'host' => $this->host,
            'driver' => $this->driver,
        );
    }
}