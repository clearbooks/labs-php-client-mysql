<?php
namespace Clearbooks\Labs\Mysql\Connection;

use Doctrine\DBAL\DriverManager;

class DoctrineConnectionProvider
{
    /**
     * @var ConnectionDetails
     */
    private $connectionDetails;

    public function __construct( ConnectionDetails $connectionDetails )
    {
        $this->connectionDetails = $connectionDetails;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getConnection()
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
