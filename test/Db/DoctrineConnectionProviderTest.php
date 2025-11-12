<?php
namespace Clearbooks\Labs\Db;

use Clearbooks\Labs\Bootstrap;
use PHPUnit\Framework\TestCase;

class DoctrineConnectionProviderTest extends TestCase
{
    private DoctrineConnectionProvider $doctrineConnectionProvider;

    public function setUp(): void
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
        $this->assertTrue( $connection->connect() );
        $this->assertTrue( $connection->isConnected() );
    }
}
