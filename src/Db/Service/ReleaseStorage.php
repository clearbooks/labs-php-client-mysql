<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Release;
use Clearbooks\Labs\Db\Table\Release as ReleaseTable;
use Clearbooks\Labs\Toggle\UseCase\ReleaseRetriever;
use Doctrine\DBAL\Connection;

class ReleaseStorage implements ReleaseRetriever
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ReleaseTable
     */
    private $releaseTable;

    /**
     * @param Connection       $connection
     * @param ReleaseTable     $releaseTable
     */
    public function __construct( Connection $connection, ReleaseTable $releaseTable )
    {
        $this->connection = $connection;
        $this->releaseTable = $releaseTable;
    }

    /**
     * @param int $releaseId
     * @return Release|null
     */
    public function getReleaseById( $releaseId )
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "*" )->from( (string)$this->releaseTable )->where( "id = ?" );
        $queryBuilder->setParameter( 0, $releaseId );

        $releaseData = $queryBuilder->execute()->fetch();
        return !empty( $releaseData ) ? new Release( $releaseData ) : null;
    }

    /**
     * @param Release $release
     * @return int
     */
    public function insertRelease( Release $release )
    {
        $affectedRows = $this->connection->insert( $this->releaseTable, $release->toArray() );
        return $affectedRows > 0 ? $this->connection->lastInsertId() : 0;
    }
}
