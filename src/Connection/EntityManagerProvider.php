<?php
namespace Clearbooks\Labs\Mysql\Connection;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerProvider
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct( Connection $connection )
    {
        $this->connection = $connection;
    }

    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEntityManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration( [ __DIR__ . "/../Entity" ],
                                                                false, null, null, false );
        return EntityManager::create( $this->connection, $config );
    }
}
