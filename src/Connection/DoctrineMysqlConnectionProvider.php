<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/08/15
 * Time: 14:47
 */

namespace Clearbooks\LabsMysql\Connection;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class DoctrineMysqlConnectionProvider implements ConnectionProvider
{

    /**
     * @var ConnectionDetails
     */
    private $connectionDetails;

    function __construct( ConnectionDetails $connectionDetails )
    {
        $this->connectionDetails = $connectionDetails;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     * @throws CannotConnectToDatabaseException
     * @throws InvalidConnectionDetailsException
     */
    public function getConnection()
    {
        $connectionDetails = $this->connectionDetails->toArray();
        foreach ($connectionDetails as $__key => $value) {
            if( is_null( $value ) ) {
                throw new InvalidConnectionDetailsException();
            }
        }

        try{
            $connection = DriverManager::getConnection( $connectionDetails, new Configuration() );
        } catch( \Exception $e ){
            throw new CannotConnectToDatabaseException();
        }

        return $connection;
    }
}