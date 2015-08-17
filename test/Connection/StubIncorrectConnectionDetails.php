<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/08/15
 * Time: 15:59
 */

namespace Clearbooks\LabsMysql\Connection;


class StubIncorrectConnectionDetails implements ConnectionDetails
{
    private $dbname = 'not';
    private $user = 'going to connect';
    private $password = '';
    private $host = '192.192.192.192';
    private $driver = 'vroom vroom';

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