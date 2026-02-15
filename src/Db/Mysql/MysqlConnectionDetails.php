<?php
namespace Clearbooks\Labs\Db\Mysql;

use Clearbooks\Labs\Db\ConnectionDetails;

class MysqlConnectionDetails implements ConnectionDetails
{
    private string $host;
    private int $port;
    private string $databaseName;
    private string $user;
    private string $password;
    private string $charset;

    public function __construct( string $host, int $port, string $databaseName, string $user, string $password,
                                 string $charset )
    {
        $this->host = $host;
        $this->port = $port;
        $this->databaseName = $databaseName;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDriver(): string
    {
        return "pdo_mysql";
    }

    public function getCharset(): string
    {
        return $this->charset;
    }
}
