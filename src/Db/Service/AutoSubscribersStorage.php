<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Table\Subscribers;
use Clearbooks\Labs\Toggle\UseCase\UserAutoSubscriptionChecker;
use Doctrine\DBAL\Connection;

class AutoSubscribersStorage implements UserAutoSubscriptionChecker
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Subscribers
     */
    private $subscribersTable;

    /**
     * @param Connection  $connection
     * @param Subscribers $subscribersTable
     */
    public function __construct( Connection $connection, Subscribers $subscribersTable )
    {
        $this->connection = $connection;
        $this->subscribersTable = $subscribersTable;
    }

    /**
     * @param string $userId
     * @return bool
     */
    public function isUserAutoSubscriber( $userId )
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "COUNT(user_id) AS cnt" )->from( (string)$this->subscribersTable )->where( "user_id = ?" );
        $queryBuilder->setParameter( 0, $userId );

        $numberOfUserIdRecords = $queryBuilder->execute()->fetchColumn();
        return $numberOfUserIdRecords > 0;
    }

    /**
     * @param string $userId
     * @return bool
     */
    public function setUserAsAutoSubscriber( $userId )
    {
        if ( $this->isUserAutoSubscriber( $userId ) ) {
            return true;
        }

        $affectedRows = $this->connection->insert( $this->subscribersTable, [ "user_id" => $userId ] );
        return $affectedRows > 0;
    }
}
