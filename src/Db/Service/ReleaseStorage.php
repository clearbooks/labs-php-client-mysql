<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Release;
use Clearbooks\Labs\Db\Table\Release as ReleaseTable;
use Clearbooks\Labs\Toggle\UseCase\ReleaseRetriever;
use Doctrine\DBAL\Connection;

class ReleaseStorage implements ReleaseRetriever
{
    private Connection $connection;
    private ReleaseTable $releaseTable;

    public function __construct( Connection $connection, ReleaseTable $releaseTable )
    {
        $this->connection = $connection;
        $this->releaseTable = $releaseTable;
    }

    public function getReleaseById( int $releaseId ): ?Release
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "*" )->from( (string)$this->releaseTable )->where( "id = ?" );
        $queryBuilder->setParameter( 0, $releaseId );

        $releaseData = $queryBuilder->execute()->fetch();
        return !empty( $releaseData ) ? new Release( $releaseData ) : null;
    }

    public function insertRelease( Release $release ): int
    {
        $affectedRows = $this->connection->insert( $this->releaseTable, $release->toArray() );
        return $affectedRows > 0 ? $this->connection->lastInsertId() : 0;
    }
}
