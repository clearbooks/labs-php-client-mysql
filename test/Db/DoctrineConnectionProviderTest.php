<?php
namespace Clearbooks\Labs\Db;

use Clearbooks\Labs\Bootstrap;

class DoctrineConnectionProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DoctrineConnectionProvider
     */
    private $doctrineConnectionProvider;

    public function setUp()
    {
        parent::setUp();
        $this->doctrineConnectionProvider = Bootstrap::getInstance()->getDIContainer()
                                                     ->get( DoctrineConnectionProvider::class );
    }

    /**
     * @test
     */
    public function GivenCorrectConnectionDetailsAreProvided_WhenRequestingConnectionFromProvider_ResultingConnectionObjectIsCapableOfConnecting()
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->doctrineConnectionProvider->getConnection();

        $this->assertNotNull( $connection );
        $this->assertTrue( $connection->ping() );
        $this->assertTrue( $connection->isConnected() );
    }
}
