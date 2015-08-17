<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 17/08/15
 * Time: 11:52
 */

namespace Clearbooks\LabsMysql\Connection;


class DoctrineQueryBuilderProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var QueryBuilderProvider
     */
    private $queryBuilderProvider;

    public function setUp()
    {
        parent::setUp();
        $this->queryBuilderProvider = new DoctrineQueryBuilderProvider( (new DoctrineMysqlConnectionProvider( new CorrectConnectionDetails() ))->getConnection() );
    }

    /**
     * @test
     */
    public function getQueryProviderReturnsQueryProvider()
    {
        $this->assertInstanceOf( '\Doctrine\DBAL\Query\QueryBuilder' , $this->queryBuilderProvider->getQueryBuilder());
    }
}
