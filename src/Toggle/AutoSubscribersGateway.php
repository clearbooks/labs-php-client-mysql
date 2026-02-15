<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Client\Toggle\Entity\Identity;
use Clearbooks\Labs\Toggle\UseCase\UserAutoSubscriptionChecker;

class AutoSubscribersGateway implements \Clearbooks\Labs\Client\Toggle\Gateway\AutoSubscribersGateway
{
    private UserAutoSubscriptionChecker $userAutoSubscriptionChecker;

    public function __construct( UserAutoSubscriptionChecker $userAutoSubscriptionChecker )
    {
        $this->userAutoSubscriptionChecker = $userAutoSubscriptionChecker;
    }

    public function isUserAutoSubscriber( Identity $user ): bool
    {
        return $this->userAutoSubscriptionChecker->isUserAutoSubscriber( $user->getId() );
    }
}
