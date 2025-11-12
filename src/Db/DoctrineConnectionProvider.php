<?php
namespace Clearbooks\Labs\Db;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DoctrineConnectionProvider
{
    private ConnectionDetails $connectionDetails;

    public function __construct( ConnectionDetails $connectionDetails )
    {
        $this->connectionDetails = $connectionDetails;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getConnection(): Connection
    {
        return DriverManager::getConnection( [
                                                     "host"     => $this->connectionDetails->getHost(),
                                                     "port"     => $this->connectionDetails->getPort(),
                                                     "dbname"   => $this->connectionDetails->getDatabaseName(),
                                                     "user"     => $this->connectionDetails->getUser(),
                                                     "password" => $this->connectionDetails->getPassword(),
                                                     "driver"   => $this->connectionDetails->getDriver(),
                                                     "charset"  => $this->connectionDetails->getCharset()
                                             ] );
    }
}
