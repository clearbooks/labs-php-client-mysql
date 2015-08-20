<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 17/08/15
 * Time: 11:53
 */

namespace Clearbooks\Labs\Mysql\Connection;


use Doctrine\DBAL\Connection;

class DoctrineQueryBuilderProvider implements QueryBuilderProvider
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * DoctrineQueryBuilderProvider constructor.
     * @param Connection $connection
     */
    public function __construct( Connection $connection )
    {
        $this->connection = $connection;
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->connection->createQueryBuilder();
    }
}