<?php
namespace Clearbooks\Labs\Db;

use Clearbooks\Labs\Bootstrap;

class EntityManagerProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerProvider
     */
    private $entityManagerProvider;

    public function setUp()
    {
        parent::setUp();
        $this->entityManagerProvider = Bootstrap::getInstance()->getDIContainer()
                                                ->get( 'Clearbooks\Labs\Db\EntityManagerProvider' );
    }

    /**
     * @test
     */
    public function GivenCorrectConnectionDetailsAreProvided_WhenRequestingEntityManagerFromProvider_ValidEntityManagerInstanceIsReturned()
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->entityManagerProvider->getEntityManager();
        $this->assertNotNull( $entityManager );
        $this->assertNotNull( $entityManager->getConnection() );
        $this->assertTrue( $entityManager->getConnection()->ping() );
        $this->assertTrue( $entityManager->getConnection()->isConnected() );
    }
}
