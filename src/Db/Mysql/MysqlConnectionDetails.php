<?php
namespace Clearbooks\Labs\Db\Mysql;

use Clearbooks\Labs\Db\ConnectionDetails;

class MysqlConnectionDetails implements ConnectionDetails
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $charset;

    /**
     * @param string $host
     * @param int $port
     * @param string $databaseName
     * @param string $user
     * @param string $password
     * @param string $charset
     */
    public function __construct( $host, $port, $databaseName, $user, $password, $charset )
    {
        $this->host = $host;
        $this->port = $port;
        $this->databaseName = $databaseName;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return "pdo_mysql";
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }
}
