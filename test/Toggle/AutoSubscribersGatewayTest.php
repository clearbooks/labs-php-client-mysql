<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\Service\AutoSubscribersStorage;
use Clearbooks\Labs\LabsTest;
use Clearbooks\Labs\Toggle\Entity\UserStub;

class AutoSubscribersGatewayTest extends LabsTest
{
    /**
     * @var AutoSubscribersStorage
     */
    private $autoSubscribersStorage;

    /**
     * @var AutoSubscribersGateway
     */
    private $autoSubscribersGateway;

    public function setUp(): void
    {
        parent::setUp();
        $this->autoSubscribersStorage = Bootstrap::getInstance()->getDIContainer()
                                                 ->get( AutoSubscribersStorage::class );

        $this->autoSubscribersGateway = new AutoSubscribersGateway( $this->autoSubscribersStorage );
    }

    /**
     * @test
     */
    public function GivenUserIsNotAutoSubscriber_ExpectIsUserAutoSubscriberToBeFalse()
    {
        $user = new UserStub( 1234 );
        $this->assertFalse( $this->autoSubscribersGateway->isUserAutoSubscriber( $user ) );
    }

    /**
     * @test
     */
    public function GivenUserIsAutoSubscriber_ExpectIsUserAutoSubscriberToBeTrue()
    {
        $user = new UserStub( 1234 );
        $this->autoSubscribersStorage->setUserAsAutoSubscriber( $user->getId() );
        $this->assertTrue( $this->autoSubscribersGateway->isUserAutoSubscriber( $user ) );
    }
}
