<?php
namespace Clearbooks\Labs;

use Clearbooks\Labs\Db\Entity\Test;
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
        $test = $this->entityManager->find( 'Clearbooks\Labs\Db\Entity\Test', 1 );
        var_dump($test);
        $test->setName( "xxyy" );

        $this->entityManager->persist( $test );
        $this->entityManager->flush();
    }
}
