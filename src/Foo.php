<?php
namespace Clearbooks\Labs\Mysql;

use Clearbooks\Labs\Mysql\Entity\Test;
use Doctrine\ORM\EntityManager;

class Foo
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct( EntityManager $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    public function doSomething()
    {
        /** @var Test $test */
        $test = $this->entityManager->find( 'Clearbooks\Labs\Mysql\Entity\Test', 1 );

        $test->setName( "xxyy" );

        $this->entityManager->persist( $test );
        $this->entityManager->flush();
    }
}
