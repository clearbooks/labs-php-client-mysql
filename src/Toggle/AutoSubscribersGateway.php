<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Toggle\UseCase\UserAutoSubscriptionChecker;

class AutoSubscribersGateway implements \Clearbooks\Labs\Client\Toggle\Gateway\AutoSubscribersGateway
{
    /**
     * @var UserAutoSubscriptionChecker
     */
    private $userAutoSubscriptionChecker;

    /**
     * @param UserAutoSubscriptionChecker $userAutoSubscriptionChecker
     */
    public function __construct( UserAutoSubscriptionChecker $userAutoSubscriptionChecker )
    {
        $this->userAutoSubscriptionChecker = $userAutoSubscriptionChecker;
    }

    /**
     * @param Identity $user
     * @return bool
     */
    public function isUserAutoSubscriber( Identity $user )
    {
        return $this->userAutoSubscriptionChecker->isUserAutoSubscriber( $user->getId() );
    }
}
